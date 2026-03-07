<?php

namespace Moonpie\EasyWechat\VirtualPay\Tests;

use PHPUnit\Framework\TestCase;
use Moonpie\EasyWechat\VirtualPay\Goods\Client;
use EasyWeChat\Kernel\ServiceContainer;
use EasyWeChat\Kernel\Contracts\AccessTokenInterface;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;

class GoodsClientTest extends TestCase
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

    public function testStartUploadGoods()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $uploadItem = [
            'goods_id' => 'goods_123',
            'goods_name' => 'Test Goods',
            'price' => 100,
        ];
        
        $result = $client->startUploadGoods($uploadItem);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/start_upload_goods', $request->getUri()->getPath());
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($uploadItem, $decodedBody['upload_item']);
        $this->assertEquals(1, $decodedBody['env']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        
        // 验证不包含 signature（因为不是用户签名接口）
        $this->assertArrayNotHasKey('signature', $query);
    }

    public function testStartUploadGoodsWithCustomEnv()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $uploadItem = [
            'goods_id' => 'goods_456',
            'goods_name' => 'Test Goods 2',
            'price' => 200,
        ];
        $env = 0; // 自定义环境
        
        $result = $client->startUploadGoods($uploadItem, $env);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($uploadItem, $decodedBody['upload_item']);
        $this->assertEquals(0, $decodedBody['env']); // 应该使用自定义环境
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
    }

    public function testQueryUploadGoods()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $result = $client->queryUploadGoods();
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/query_upload_goods', $request->getUri()->getPath());
        
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

    public function testQueryUploadGoodsWithCustomEnv()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $env = 0; // 自定义环境
        
        $result = $client->queryUploadGoods($env);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals(0, $decodedBody['env']); // 应该使用自定义环境
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
    }

    public function testStartPublishGoods()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $publishItem = [
            'goods_id' => 'goods_789',
            'goods_name' => 'Test Publish Goods',
            'price' => 300,
        ];
        
        $result = $client->startPublishGoods($publishItem);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/start_publish_goods', $request->getUri()->getPath());
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($publishItem, $decodedBody['publish_item']);
        $this->assertEquals(1, $decodedBody['env']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        
        // 验证不包含 signature（因为不是用户签名接口）
        $this->assertArrayNotHasKey('signature', $query);
    }

    public function testStartPublishGoodsWithCustomEnv()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $publishItem = [
            'goods_id' => 'goods_000',
            'goods_name' => 'Test Publish Goods 2',
            'price' => 400,
        ];
        $env = 0; // 自定义环境
        
        $result = $client->startPublishGoods($publishItem, $env);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($publishItem, $decodedBody['publish_item']);
        $this->assertEquals(0, $decodedBody['env']); // 应该使用自定义环境
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
    }

    public function testQueryPublishGoods()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $result = $client->queryPublishGoods();
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/query_publish_goods', $request->getUri()->getPath());
        
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

    public function testQueryPublishGoodsWithCustomEnv()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $env = 0; // 自定义环境
        
        $result = $client->queryPublishGoods($env);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals(0, $decodedBody['env']); // 应该使用自定义环境
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
    }
}