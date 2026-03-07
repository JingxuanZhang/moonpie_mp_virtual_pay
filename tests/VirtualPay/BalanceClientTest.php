<?php

namespace Moonpie\EasyWechat\VirtualPay\Tests;

use PHPUnit\Framework\TestCase;
use Moonpie\EasyWechat\VirtualPay\Balance\Client;
use EasyWeChat\Kernel\ServiceContainer;
use EasyWeChat\Kernel\Contracts\AccessTokenInterface;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class BalanceClientTest extends TestCase
{
    private $app;
    private $history;
    private $handlerStack;

    protected function setUp(): void
    {
        parent::setUp();
        // 创建一个可以记录请求历史的 HandlerStack
        $this->handlerStack = MockHandler::createWithMiddleware([
            new Response(200, ['X-Foo' => 'Bar'], json_encode(['result' => 'success'])),
            new Response(200, ['X-Foo' => 'Bar'], json_encode(['result' => 'success'])),
            new Response(200, ['X-Foo' => 'Bar'], json_encode(['result' => 'success'])),
            new Response(200, ['X-Foo' => 'Bar'], json_encode(['result' => 'success'])),
        ]);

        // 添加一个中间件来记录请求历史
        $this->history = [];
        $historyMiddleware = \GuzzleHttp\Middleware::history($this->history);
        $this->handlerStack->push($historyMiddleware);

        // 模拟 access_token 服务
        $mockAccessToken = $this->createMock(AccessTokenInterface::class);
        // 创建模拟的 ServiceContainer
        $this->app = new ServiceContainer([
            'app_key' => 'test_app_key_123456',
            'virtual_pay' => [
                'env' => 1,
            ],
            'http' => [
                'timeout' => 5.0,
                'base_uri' => 'https://api.example.com/',
            ]
        ], [
            'access_token' => $mockAccessToken,
        ]);
    }

    public function testQueryUserBalance()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);

        $openid = 'test_openid_123';
        $userIp = '192.168.1.1';
        $sessionKey = 'test_session_key_789';

        $result = $client->queryUserBalance($openid, $userIp, $sessionKey);

        $this->assertNotNull($result);

        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];

        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());

        // 验证请求 URL path
        $this->assertEquals('https://api.weixin.qq.com', $request->getUri()->getScheme() . '://' . $request->getUri()->getHost());
        $this->assertEquals('/xpay/query_user_balance', $request->getUri()->getPath());

        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);

        $this->assertEquals($openid, $decodedBody['openid']);
        $this->assertEquals(1, $decodedBody['env']);
        $this->assertEquals($userIp, $decodedBody['user_ip']);

        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);

        $this->assertArrayHasKey('pay_sig', $query);
    }

    public function testQueryUserBalanceWithDifferentEnv()
    {
        // 创建一个不同环境的 app 实例
        $app = new ServiceContainer([
            'virtual_pay' => [
                'app_key' => 'test_app_key_123456',
                'env' => 0,
            ],
            'http' => [
                'timeout' => 5.0,
                'base_uri' => 'https://api.example.com/',
            ]
        ]);

        $mockHandler = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], json_encode(['result' => 'success'])),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $history = [];
        $historyMiddleware = \GuzzleHttp\Middleware::history($history);
        $handlerStack->push($historyMiddleware);


        $mockAccessToken = $this->createMock(AccessTokenInterface::class);
        $app['access_token'] = $mockAccessToken;

        $client = new Client($app);
        $client->setHandlerStack($handlerStack);

        $openid = 'test_openid_456';
        $userIp = '10.0.0.1';
        $sessionKey = 'test_session_key_000';

        $result = $client->queryUserBalance($openid, $userIp, $sessionKey);

        $this->assertNotNull($result);

        // 验证请求历史
        $this->assertCount(1, $history);
        $request = $history[0]['request'];

        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);

        $this->assertEquals($openid, $decodedBody['openid']);
        $this->assertEquals(0, $decodedBody['env']);
        $this->assertEquals($userIp, $decodedBody['user_ip']);

        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);

        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('signature', $query);
    }

    public function testQueryBizBalance()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);

        $result = $client->queryBizBalance();

        $this->assertNotNull($result);

        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];

        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());

        // 验证请求 URL path
        $this->assertEquals('https://api.weixin.qq.com', $request->getUri()->getScheme() . '://' . $request->getUri()->getHost());
        $this->assertEquals('/xpay/query_biz_balance', $request->getUri()->getPath());

        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);

        $this->assertEquals(1, $decodedBody['env']);

        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);

        $this->assertArrayHasKey('pay_sig', $query);

        // 验证不包含 signature（因为不是用户签名接口）
        $this->assertArrayNotHasKey('signature', $query);
    }

    public function testQueryBizBalanceWithDifferentEnv()
    {
        // 创建一个不同环境的 app 实例
        $app = new ServiceContainer([
            'app_key' => 'test_app_key_123456',
            'env' => 0,
            'virtual_pay' => [
                'env' => 0,
            ],
            'http' => [
                'timeout' => 5.0,
                'base_uri' => 'https://api.example.com/',
            ]
        ]);

        $mockHandler = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], json_encode(['result' => 'success'])),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $history = [];
        $historyMiddleware = \GuzzleHttp\Middleware::history($history);
        $handlerStack->push($historyMiddleware);

        $mockAccessToken = $this->createMock(AccessTokenInterface::class);
        $app['access_token'] = $mockAccessToken;

        $client = new Client($app);
        $client->setHandlerStack($handlerStack);

        $result = $client->queryBizBalance();

        $this->assertNotNull($result);

        // 验证请求历史
        $this->assertCount(1, $history);
        $request = $history[0]['request'];

        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);

        $this->assertEquals(0, $decodedBody['env']);

        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);

        $this->assertArrayHasKey('pay_sig', $query);
    }
}

