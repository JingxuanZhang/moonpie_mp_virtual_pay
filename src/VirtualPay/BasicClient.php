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
    public function getEnv($params = null)
    {
        if ($params !== null && isset($params['env'])) {
            return (int) $params['env'];
        }

        return (int) $this->app->config->get('virtual_pay.env', 0);
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
        $appKey = $this->getEnvAppKey();

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

        if (isset($options['body'])) {
            $postBody = $options['body'];
        } elseif (isset($options['json'])) {
            $postBody = json_encode($options['json'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } elseif (isset($options['form_params'])) {
            $postBody = http_build_query($options['form_params']);
        }
        unset($options['json'], $options['form_params']);
        $options['body'] = $postBody;
        //var_dump($postBody); exit;

        // Generate pay_sig for all requests
        $paySig = $this->generatePaySig($uriPath, $postBody, $appKey);

        // Add pay_sig to query parameters, preserving existing ones
        if (!isset($options['query'])) {
            $options['query'] = [];
        }
        // Merge existing query parameters with new ones
        $options['query'] = array_merge($existingQuery, $options['query']);
        $options['query']['pay_sig'] = $paySig;
        //query不需要env
        //$options['query']['env'] = $env;

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
        return hash_hmac('sha256', $needSignMsg, $appKey, false);
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
        parent::registerHttpMiddlewares();
    }
    protected function getEnvAppKey()
    {
        $sandbox = $this->getEnv();
        if ($sandbox) {
            return $this->app->config->get('virtual_pay.sandbox_app_key', '');
        }
        return $this->app->config->get('virtual_pay.app_key', '');
    }
    /**
     * 生成wxapi需要的虚拟支付必要参数
     * @link https://developers.weixin.qq.com/miniprogram/dev/api/payment/wx.requestVirtualPayment.html
     */
    public function buildVirtualPayData(array $signData, $mode, $sessionKey)
    {
        $json = [
            'signData' => $signData,
            'mode' => $mode,
        ];
        $uriWxApi = 'requestVirtualPayment';
        $postBody = json_encode($signData);
        $appKey = $this->getEnvAppKey($signData);
        $json['paySig'] = $this->generatePaySig($uriWxApi, $postBody, $appKey);
        $json['signature'] = $this->generateSignature($postBody, $sessionKey);
        $json['signData'] = $postBody;

        return $json;
    }
}
