<?php

namespace Moonpie\EasyWechat\VirtualPay\Tests;

use PHPUnit\Framework\TestCase;
use Moonpie\EasyWechat\VirtualPay\Order\Client;
use EasyWeChat\Kernel\ServiceContainer;
use EasyWeChat\Kernel\Contracts\AccessTokenInterface;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;

class OrderClientTest extends TestCase
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

    public function testQueryOrderWithOrderId()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $orderId = 'order_123';
        $openid = 'test_openid_123';
        
        $result = $client->queryOrder($orderId, $openid);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/query_order', $request->getUri()->getPath());
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($openid, $decodedBody['openid']);
        $this->assertEquals(1, $decodedBody['env']);
        $this->assertEquals($orderId, $decodedBody['order_id']);
        $this->assertArrayNotHasKey('wx_order_id', $decodedBody);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        
        // 验证不包含 signature（因为不是用户签名接口）
        $this->assertArrayNotHasKey('signature', $query);
    }

    public function testQueryOrderWithWxOrderId()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $orderId = 'wx_order_456';
        $openid = 'test_openid_456';
        
        $result = $client->queryOrder($orderId, $openid);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($openid, $decodedBody['openid']);
        $this->assertEquals(1, $decodedBody['env']);
        $this->assertEquals($orderId, $decodedBody['wx_order_id']);
        $this->assertArrayNotHasKey('order_id', $decodedBody);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
    }

    public function testQueryOrderWithCustomEnv()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $orderId = 'order_789';
        $openid = 'test_openid_789';
        $env = 0; // 自定义环境
        
        $result = $client->queryOrder($orderId, $openid, $env);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($openid, $decodedBody['openid']);
        $this->assertEquals(0, $decodedBody['env']); // 应该使用自定义环境
        $this->assertEquals($orderId, $decodedBody['order_id']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
    }

    public function testNotifyProvideGoodsWithOrderId()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $orderId = 'order_111';
        
        $result = $client->notifyProvideGoods($orderId);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/notify_provide_goods', $request->getUri()->getPath());
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals(1, $decodedBody['env']);
        $this->assertEquals($orderId, $decodedBody['order_id']);
        $this->assertArrayNotHasKey('wx_order_id', $decodedBody);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        
        // 验证不包含 signature（因为不是用户签名接口）
        $this->assertArrayNotHasKey('signature', $query);
    }

    public function testNotifyProvideGoodsWithWxOrderId()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $orderId = 'order_222';
        $wxOrderId = 'wx_order_333';
        
        $result = $client->notifyProvideGoods($orderId, $wxOrderId);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals(1, $decodedBody['env']);
        $this->assertEquals($wxOrderId, $decodedBody['wx_order_id']);
        $this->assertArrayNotHasKey('order_id', $decodedBody);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
    }

    public function testNotifyProvideGoodsWithCustomEnv()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $orderId = 'order_444';
        $env = 0; // 自定义环境
        
        $result = $client->notifyProvideGoods($orderId, null, $env);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals(0, $decodedBody['env']); // 应该使用自定义环境
        $this->assertEquals($orderId, $decodedBody['order_id']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
    }

    public function testRefundOrder()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $params = [
            'openid' => 'test_openid_555',
            'refund_order_id' => 'refund_order_555',
            'left_fee' => 100,
            'refund_fee' => 50,
            'order_id' => 'order_555',
        ];
        
        $result = $client->refundOrder($params);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/refund_order', $request->getUri()->getPath());
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($params['openid'], $decodedBody['openid']);
        $this->assertEquals(1, $decodedBody['env']);
        $this->assertEquals($params['refund_order_id'], $decodedBody['refund_order_id']);
        $this->assertEquals($params['left_fee'], $decodedBody['left_fee']);
        $this->assertEquals($params['refund_fee'], $decodedBody['refund_fee']);
        $this->assertEquals($params['order_id'], $decodedBody['order_id']);
        $this->assertEquals('', $decodedBody['biz_meta']);
        $this->assertEquals('0', $decodedBody['refund_reason']);
        $this->assertEquals('1', $decodedBody['req_from']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        
        // 验证不包含 signature（因为不是用户签名接口）
        $this->assertArrayNotHasKey('signature', $query);
    }

    public function testRefundOrderWithWxOrderId()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $params = [
            'openid' => 'test_openid_666',
            'refund_order_id' => 'refund_order_666',
            'left_fee' => 200,
            'refund_fee' => 100,
            'wx_order_id' => 'wx_order_666', // 使用 wx_order_id
            'biz_meta' => 'test meta',
            'refund_reason' => 'test reason',
            'req_from' => '2',
        ];
        
        $result = $client->refundOrder($params);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($params['openid'], $decodedBody['openid']);
        $this->assertEquals(1, $decodedBody['env']);
        $this->assertEquals($params['refund_order_id'], $decodedBody['refund_order_id']);
        $this->assertEquals($params['left_fee'], $decodedBody['left_fee']);
        $this->assertEquals($params['refund_fee'], $decodedBody['refund_fee']);
        $this->assertEquals($params['wx_order_id'], $decodedBody['wx_order_id']);
        $this->assertEquals($params['biz_meta'], $decodedBody['biz_meta']);
        $this->assertEquals($params['refund_reason'], $decodedBody['refund_reason']);
        $this->assertEquals($params['req_from'], $decodedBody['req_from']);
        $this->assertArrayNotHasKey('order_id', $decodedBody);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
    }

    public function testRefundOrderWithCustomEnv()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $params = [
            'openid' => 'test_openid_777',
            'refund_order_id' => 'refund_order_777',
            'left_fee' => 300,
            'refund_fee' => 150,
            'order_id' => 'order_777',
            'env' => 0, // 自定义环境
        ];
        
        $result = $client->refundOrder($params);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($params['openid'], $decodedBody['openid']);
        $this->assertEquals(0, $decodedBody['env']); // 应该使用自定义环境
        $this->assertEquals($params['refund_order_id'], $decodedBody['refund_order_id']);
        $this->assertEquals($params['left_fee'], $decodedBody['left_fee']);
        $this->assertEquals($params['refund_fee'], $decodedBody['refund_fee']);
        $this->assertEquals($params['order_id'], $decodedBody['order_id']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
    }
}