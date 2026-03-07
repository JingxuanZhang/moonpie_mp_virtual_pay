<?php

namespace Moonpie\EasyWechat\VirtualPay\Tests;

use PHPUnit\Framework\TestCase;
use Moonpie\EasyWechat\VirtualPay\Currency\Client;
use EasyWeChat\Kernel\ServiceContainer;
use EasyWeChat\Kernel\Contracts\AccessTokenInterface;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;

class CurrencyClientTest extends TestCase
{
    private $app;
    private $mockHandler;
    private $handlerStack;
    private $history;

    protected function setUp(): void
    {
        parent::setUp();

        // 创建模拟的 ServiceContainer
        $this->app = new ServiceContainer([
            'app_key' => 'test_app_key_123456',
            'env' => 1,
            'virtual_pay' => [
                'env' => 1,
            ],
            'http' => [
                'timeout' => 5.0,
                'base_uri' => 'https://api.example.com/',
            ]
        ]);

        // 创建模拟的 HTTP 响应处理器
        $this->mockHandler = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], json_encode(['result' => 'success'])),
            new Response(200, ['X-Foo' => 'Bar'], json_encode(['result' => 'success'])),
            new Response(200, ['X-Foo' => 'Bar'], json_encode(['result' => 'success'])),
            new Response(200, ['X-Foo' => 'Bar'], json_encode(['result' => 'success'])),
            new Response(200, ['X-Foo' => 'Bar'], json_encode(['result' => 'success'])),
            new Response(200, ['X-Foo' => 'Bar'], json_encode(['result' => 'success'])),
        ]);

        // 创建一个可以记录请求历史的 HandlerStack
        $this->handlerStack = HandlerStack::create($this->mockHandler);

        // 添加一个中间件来记录请求历史
        $this->history = [];
        $historyMiddleware = \GuzzleHttp\Middleware::history($this->history);
        $this->handlerStack->push($historyMiddleware);

        // 模拟 access_token 服务
        $mockAccessToken = $this->createMock(AccessTokenInterface::class);
        $this->app['access_token'] = $mockAccessToken;
    }

    public function testCurrencyPay()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);

        $params = [
            'openid' => 'test_openid_123',
            'user_ip' => '192.168.1.1',
            'amount' => 100,
            'order_id' => 'order_123',
            'payitem' => 'item_123',
            'remark' => 'test payment',
        ];
        $sessionKey = 'test_session_key_789';

        $result = $client->currencyPay($params, $sessionKey);

        $this->assertNotNull($result);

        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];

        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());

        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertStringEndsWith('xpay/currency_pay', $request->getUri()->getPath());

        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);

        $this->assertEquals($params['openid'], $decodedBody['openid']);
        $this->assertEquals(1, $decodedBody['env']);
        $this->assertEquals($params['user_ip'], $decodedBody['user_ip']);
        $this->assertEquals($params['amount'], $decodedBody['amount']);
        $this->assertEquals($params['order_id'], $decodedBody['order_id']);
        $this->assertEquals($params['payitem'], $decodedBody['payitem']);
        $this->assertEquals($params['remark'], $decodedBody['remark']);

        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);

        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('signature', $query);
    }

    public function testCurrencyPayWithCustomEnv()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);

        $params = [
            'openid' => 'test_openid_456',
            'user_ip' => '10.0.0.1',
            'amount' => 200,
            'order_id' => 'order_456',
            'payitem' => 'item_456',
            'env' => 0, // 自定义环境
        ];
        $sessionKey = 'test_session_key_000';

        $result = $client->currencyPay($params, $sessionKey);

        $this->assertNotNull($result);

        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];

        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);

        $this->assertEquals($params['openid'], $decodedBody['openid']);
        $this->assertEquals(0, $decodedBody['env']); // 应该使用自定义环境
        $this->assertEquals($params['user_ip'], $decodedBody['user_ip']);
        $this->assertEquals($params['amount'], $decodedBody['amount']);
        $this->assertEquals($params['order_id'], $decodedBody['order_id']);
        $this->assertEquals($params['payitem'], $decodedBody['payitem']);

        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);

        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('signature', $query);
    }

    public function testCancelCurrencyPay()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);

        $params = [
            'openid' => 'test_openid_789',
            'user_ip' => '172.16.0.1',
            'pay_order_id' => 'pay_order_789',
            'order_id' => 'order_789',
            'amount' => 50,
        ];
        $sessionKey = 'test_session_key_111';

        $result = $client->cancelCurrencyPay($params, $sessionKey);

        $this->assertNotNull($result);

        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];

        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());

        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertStringEndsWith('xpay/cancel_currency_pay', $request->getUri()->getPath());

        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);

        $this->assertEquals($params['openid'], $decodedBody['openid']);
        $this->assertEquals(1, $decodedBody['env']);
        $this->assertEquals($params['user_ip'], $decodedBody['user_ip']);
        $this->assertEquals($params['pay_order_id'], $decodedBody['pay_order_id']);
        $this->assertEquals($params['order_id'], $decodedBody['order_id']);
        $this->assertEquals($params['amount'], $decodedBody['amount']);

        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);

        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('signature', $query);
    }

    public function testCancelCurrencyPayWithCustomEnv()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);

        $params = [
            'openid' => 'test_openid_999',
            'user_ip' => '192.168.10.1',
            'pay_order_id' => 'pay_order_999',
            'order_id' => 'order_999',
            'amount' => 75,
            'env' => 0, // 自定义环境
        ];
        $sessionKey = 'test_session_key_222';

        $result = $client->cancelCurrencyPay($params, $sessionKey);

        $this->assertNotNull($result);

        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];

        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);

        $this->assertEquals($params['openid'], $decodedBody['openid']);
        $this->assertEquals(0, $decodedBody['env']); // 应该使用自定义环境
        $this->assertEquals($params['user_ip'], $decodedBody['user_ip']);
        $this->assertEquals($params['pay_order_id'], $decodedBody['pay_order_id']);
        $this->assertEquals($params['order_id'], $decodedBody['order_id']);
        $this->assertEquals($params['amount'], $decodedBody['amount']);

        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);

        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('signature', $query);
    }

    public function testPresentCurrency()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);

        $params = [
            'openid' => 'test_openid_321',
            'order_id' => 'order_321',
            'amount' => 300,
        ];

        $result = $client->presentCurrency($params);

        $this->assertNotNull($result);

        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];

        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());

        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertStringEndsWith('xpay/present_currency', $request->getUri()->getPath());

        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);

        $this->assertEquals($params['openid'], $decodedBody['openid']);
        $this->assertEquals(1, $decodedBody['env']);
        $this->assertEquals($params['order_id'], $decodedBody['order_id']);
        $this->assertEquals($params['amount'], $decodedBody['amount']);

        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);

        $this->assertArrayHasKey('pay_sig', $query);

        // 验证不包含 signature（因为不是用户签名接口）
        $this->assertArrayNotHasKey('signature', $query);
    }

    public function testPresentCurrencyWithCustomEnv()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);

        $params = [
            'openid' => 'test_openid_654',
            'order_id' => 'order_654',
            'amount' => 400,
            'env' => 0, // 自定义环境
        ];

        $result = $client->presentCurrency($params);

        $this->assertNotNull($result);

        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];

        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);

        $this->assertEquals($params['openid'], $decodedBody['openid']);
        $this->assertEquals(0, $decodedBody['env']); // 应该使用自定义环境
        $this->assertEquals($params['order_id'], $decodedBody['order_id']);
        $this->assertEquals($params['amount'], $decodedBody['amount']);

        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);

        $this->assertArrayHasKey('pay_sig', $query);

        // 验证不包含 signature（因为不是用户签名接口）
        $this->assertArrayNotHasKey('signature', $query);
    }
}

