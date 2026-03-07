<?php

namespace Moonpie\EasyWechat\VirtualPay\Tests;

use PHPUnit\Framework\TestCase;
use Moonpie\EasyWechat\VirtualPay\Withdraw\Client;
use EasyWeChat\Kernel\ServiceContainer;
use EasyWeChat\Kernel\Contracts\AccessTokenInterface;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;

class WithdrawClientTest extends TestCase
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

    public function testCreateWithdrawOrder()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $params = [
            'openid' => 'test_openid_123',
            'amount' => 1000,
            'withdraw_type' => 1,
            'desc' => 'Test withdrawal',
        ];
        
        $result = $client->createWithdrawOrder($params);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/create_withdraw_order', $request->getUri()->getPath());
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($params['openid'], $decodedBody['openid']);
        $this->assertEquals($params['amount'], $decodedBody['amount']);
        $this->assertEquals($params['withdraw_type'], $decodedBody['withdraw_type']);
        $this->assertEquals($params['desc'], $decodedBody['desc']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        
        // 验证不包含 signature（因为不是用户签名接口）
        $this->assertArrayNotHasKey('signature', $query);
    }

    public function testCreateWithdrawOrderWithAllParams()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $params = [
            'openid' => 'test_openid_456',
            'amount' => 2000,
            'withdraw_type' => 2,
            'desc' => 'Test withdrawal with all params',
            'env' => 1, // 这个参数会被忽略，因为方法内部不处理 env
        ];
        
        $result = $client->createWithdrawOrder($params);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($params['openid'], $decodedBody['openid']);
        $this->assertEquals($params['amount'], $decodedBody['amount']);
        $this->assertEquals($params['withdraw_type'], $decodedBody['withdraw_type']);
        $this->assertEquals($params['desc'], $decodedBody['desc']);
        // 验证 env 参数没有被添加到请求体中
        $this->assertArrayNotHasKey('env', $decodedBody);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
    }

    public function testQueryWithdrawOrder()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $withdrawNo = 'withdraw_123';
        
        $result = $client->queryWithdrawOrder($withdrawNo);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/query_withdraw_order', $request->getUri()->getPath());
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($withdrawNo, $decodedBody['withdraw_no']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        
        // 验证不包含 signature（因为不是用户签名接口）
        $this->assertArrayNotHasKey('signature', $query);
    }

    public function testQueryWithdrawOrderWithCustomEnv()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $withdrawNo = 'withdraw_456';
        $env = 0; // 自定义环境
        
        $result = $client->queryWithdrawOrder($withdrawNo, $env);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($withdrawNo, $decodedBody['withdraw_no']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
    }

    public function testQueryWithdrawOrderWithNullEnv()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $withdrawNo = 'withdraw_789';
        
        $result = $client->queryWithdrawOrder($withdrawNo, null);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($withdrawNo, $decodedBody['withdraw_no']);
        $this->assertArrayNotHasKey('env', $decodedBody);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
    }
}