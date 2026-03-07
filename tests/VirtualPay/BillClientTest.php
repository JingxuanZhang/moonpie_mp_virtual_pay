<?php

namespace Moonpie\EasyWechat\VirtualPay\Tests;

use PHPUnit\Framework\TestCase;
use Moonpie\EasyWechat\VirtualPay\Bill\Client;
use EasyWeChat\Kernel\ServiceContainer;
use EasyWeChat\Kernel\Contracts\AccessTokenInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;

class BillClientTest extends TestCase
{
    private $app;
    private $history;
    private $handlerStack;

    protected function setUp(): void
    {
        parent::setUp();
        
        // 创建模拟的 HTTP 响应处理器
        $mockHandler = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], json_encode(['result' => 'success'])),
            new Response(200, ['X-Foo' => 'Bar'], json_encode(['result' => 'success'])),
        ]);
        
        // 创建一个可以记录请求历史的 HandlerStack
        $this->handlerStack = HandlerStack::create($mockHandler);
        
        // 添加一个中间件来记录请求历史
        $this->history = [];
        $historyMiddleware = \GuzzleHttp\Middleware::history($this->history);
        $this->handlerStack->push($historyMiddleware);
        
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
        
        // 模拟 access_token 服务
        $mockAccessToken = $this->createMock(AccessTokenInterface::class);
        $this->app['access_token'] = $mockAccessToken;
    }

    public function testDownloadBill()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $beginDs = 20230801;
        $endDs = 20230810;
        
        $result = $client->downloadBill($beginDs, $endDs);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertStringEndsWith('xpay/download_bill', $request->getUri()->getPath());
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($beginDs, $decodedBody['begin_ds']);
        $this->assertEquals($endDs, $decodedBody['end_ds']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);

        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayNotHasKey('env', $query);

        // 验证不包含 signature（因为不是用户签名接口）
        $this->assertArrayNotHasKey('signature', $query);
    }

    public function testDownloadBillWithDifferentDates()
    {
        $client = new Client($this->app);
        $client->setHandlerStack($this->handlerStack);
        
        $beginDs = 20220101;
        $endDs = 20221231;
        
        $result = $client->downloadBill($beginDs, $endDs);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($beginDs, $decodedBody['begin_ds']);
        $this->assertEquals($endDs, $decodedBody['end_ds']);

        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);

        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayNotHasKey('env', $query);
    }
}