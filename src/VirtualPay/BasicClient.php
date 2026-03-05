<?php

namespace Moonpie\EasyWechat\VirtualPay;

use EasyWeChat\Kernel\BaseClient;
use EasyWeChat\Kernel\ServiceContainer;

/**
 * Basic Client for Virtual Pay
 */
class BasicClient extends BaseClient
{
    /**
     * The URI for the current client.
     *
     * @var string
     */
    protected $uri;

    /**
     * Interfaces that need user signature.
     *
     * @var array
     */
    protected $needUserSignature = [
        'xpay/query_user_balance',
        'xpay/currency_pay',
        'xpay/cancel_currency_pay',
    ];

    /**
     * Get env from config or params.
     *
     * @param array|null $params
     * @return int
     */
    protected function getEnv($params = null)
    {
        if ($params !== null && isset($params['env'])) {
            return (int) $params['env'];
        }
        
        return (int) $this->app['config']['virtual_pay']['env'] ?? 0;
    }

    /**
     * Constructor.
     *
     * @param ServiceContainer $app
     * @param \EasyWeChat\Kernel\Contracts\AccessTokenInterface|null $accessToken
     */
    public function __construct(ServiceContainer $app, $accessToken = null)
    {
        parent::__construct($app, $accessToken);
        $this->uri = $this->app['config']['http']['base_uri'] ?? '';
    }

    /**
     * Override the request method to add signatures.
     *
     * @param string $url
     * @param string $method
     * @param array $options
     * @param bool $returnRaw
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function request(string $url, string $method = 'GET', array $options = [], $returnRaw = false)
    {
        // Get appKey from config
        $appKey = $this->app['config']['app_key'] ?? '';

        // Extract URI path (without query string)
        $uriPath = parse_url($url, PHP_URL_PATH) ?: $url;
        
        // Parse existing query parameters from the URL
        $existingQuery = [];
        $parsedUrl = parse_url($url);
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $existingQuery);
        }

        // Get post body and extract env from it
        $postBody = '';
        $env = $this->app['config']['virtual_pay']['env'] ?? 0; // default env
        
        if (isset($options['body'])) {
            $postBody = $options['body'];
        } elseif (isset($options['json'])) {
            $postBody = json_encode($options['json'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            // Extract env from json body if present
            if (isset($options['json']['env'])) {
                $env = (int) $options['json']['env'];
            }
        } elseif (isset($options['form_params'])) {
            $postBody = http_build_query($options['form_params']);
            // Extract env from form_params if present
            if (isset($options['form_params']['env'])) {
                $env = (int) $options['form_params']['env'];
            }
        }

        // Generate pay_sig for all requests
        $paySig = $this->generatePaySig($uriPath, $postBody, $appKey);

        // Add pay_sig to query parameters, preserving existing ones
        if (!isset($options['query'])) {
            $options['query'] = [];
        }
        // Merge existing query parameters with new ones
        $options['query'] = array_merge($existingQuery, $options['query']);
        $options['query']['pay_sig'] = $paySig;
        $options['query']['env'] = $env;

        // Check if user signature is needed
        $needsUserSignature = false;
        foreach ($this->needUserSignature as $interface) {
            if (strpos($uriPath, '/' . $interface) !== false) {
                $needsUserSignature = true;
                break;
            }
        }

        // Generate signature if needed and session_key is provided
        if ($needsUserSignature && isset($options['session_key'])) {
            $sessionKey = $options['session_key'];
            $signature = $this->generateSignature($postBody, $sessionKey);
            $options['query']['signature'] = $signature;
            unset($options['session_key']); // Remove session_key from options
        }

        return parent::request($url, $method, $options, $returnRaw);
    }

    /**
     * Generate pay_sig signature.
     *
     * @param string $uri
     * @param string $postBody
     * @param string $appKey
     * @return string
     */
    protected function generatePaySig($uri, $postBody, $appKey)
    {
        $needSignMsg = $uri . '&' . $postBody;
        return hash_hmac('sha256', $needSignMsg, $appKey);
    }

    /**
     * Generate user signature.
     *
     * @param string $postBody
     * @param string $sessionKey
     * @return string
     */
    protected function generateSignature($postBody, $sessionKey)
    {
        return hash_hmac('sha256', $postBody, $sessionKey);
    }

    /**
     * POST JSON request with session key.
     *
     * @param string $url
     * @param array $data
     * @param array $query
     * @param string|null $sessionKey
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function httpPostJson($url, $data = [], $query = [], $sessionKey = null)
    {
        $options = [
            'json' => $data,
            'query' => $query,
        ];

        if ($sessionKey !== null) {
            $options['session_key'] = $sessionKey;
        }

        return $this->request($url, 'POST', $options);
    }

    /**
     * POST form request with session key.
     *
     * @param string $url
     * @param array $data
     * @param array $query
     * @param string|null $sessionKey
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function httpPost($url, $data = [], $query = [], $sessionKey = null)
    {
        $options = [
            'form_params' => $data,
            'query' => $query,
        ];

        if ($sessionKey !== null) {
            $options['session_key'] = $sessionKey;
        }

        return $this->request($url, 'POST', $options);
    }
    
    /**
     * Override to prevent middleware registration during testing
     */
    protected function registerHttpMiddlewares()
    {
        // Do nothing to prevent automatic middleware registration that might trigger HTTP requests
    }
    
    /**
     * Override to ensure the correct HTTP client is used
     */
    public function getHttpClient(): \GuzzleHttp\ClientInterface
    {
        if (!($this->httpClient instanceof \GuzzleHttp\ClientInterface)) {
            if (property_exists($this, 'app') && isset($this->app['http_client'])) {
                $this->httpClient = $this->app['http_client'];
            } else {
                $this->httpClient = new \GuzzleHttp\Client();
            }
        }

        return $this->httpClient;
    }
    
    /**
     * Override to ensure the correct handler stack is used
     */
    public function getHandlerStack(): \GuzzleHttp\HandlerStack
    {
        if ($this->handlerStack) {
            return $this->handlerStack;
        }

        $this->handlerStack = \GuzzleHttp\HandlerStack::create($this->getGuzzleHandler());

        foreach ($this->middlewares as $name => $middleware) {
            $this->handlerStack->push($middleware, $name);
        }

        return $this->handlerStack;
    }
    
    /**
     * Override to return the mock handler from the app container
     */
    protected function getGuzzleHandler()
    {
        // Check if we have a mock handler in the app container
        if (property_exists($this, 'app') && isset($this->app['http_client'])) {
            $httpClient = $this->app['http_client'];
            // If the http client has a mock handler, use it
            if ($httpClient instanceof \GuzzleHttp\Client) {
                $handlerStack = $httpClient->getConfig('handler');
                if ($handlerStack instanceof \GuzzleHttp\HandlerStack) {
                    // Extract the handler from the stack
                    $coreHandler = $handlerStack->resolve();
                    return $coreHandler;
                }
            }
        }
        
        // Fallback to default behavior
        if (property_exists($this, 'app') && isset($this->app['guzzle_handler'])) {
            return is_string($handler = $this->app->raw('guzzle_handler'))
                        ? new $handler()
                        : $handler;
        }

        return \GuzzleHttp\choose_handler();
    }
}