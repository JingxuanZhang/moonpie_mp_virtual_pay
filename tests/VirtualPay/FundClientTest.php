<?php

namespace Moonpie\EasyWechat\VirtualPay\Tests;

use PHPUnit\Framework\TestCase;
use Moonpie\EasyWechat\VirtualPay\Fund\Client;
use EasyWeChat\Kernel\ServiceContainer;
use EasyWeChat\Kernel\Contracts\AccessTokenInterface;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;

class FundClientTest extends TestCase
{
    private $app;
    private $mockHandler;
    private $httpClient;
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
            new Response(200, ['X-Foo' => 'Bar'], json_encode(['result' => 'success'])),
        ]);
        
        // 创建一个可以记录请求历史的 HandlerStack
        $handlerStack = HandlerStack::create($this->mockHandler);
        
        // 添加一个中间件来记录请求历史
        $this->history = [];
        $historyMiddleware = \GuzzleHttp\Middleware::history($this->history);
        $handlerStack->push($historyMiddleware);
        
        $this->httpClient = new HttpClient(['handler' => $handlerStack]);
        $this->app['http_client'] = $this->httpClient;
        
        // 模拟 access_token 服务
        $mockAccessToken = $this->createMock(AccessTokenInterface::class);
        $this->app['access_token'] = $mockAccessToken;
    }

    public function testQueryTransferAccount()
    {
        $client = new Client($this->app);
        
        $result = $client->queryTransferAccount();
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/query_transfer_account', $request->getUri()->getPath());
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        // 验证请求体为空数组
        $this->assertEmpty($decodedBody);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('env', $query);
        $this->assertEquals(1, $query['env']);
        
        // 验证不包含 signature（因为不是用户签名接口）
        $this->assertArrayNotHasKey('signature', $query);
    }

    public function testQueryTransferAccountWithCustomEnv()
    {
        $client = new Client($this->app);
        
        $env = 0; // 自定义环境
        
        $result = $client->queryTransferAccount($env);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        // 验证 env 参数在请求体中
        $this->assertEquals($env, $decodedBody['env']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('env', $query);
        $this->assertEquals(0, $query['env']); // 应该使用自定义环境
    }

    public function testQueryTransferAccountWithNullEnv()
    {
        $client = new Client($this->app);
        
        $result = $client->queryTransferAccount(null);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        // 验证请求体为空数组（env 为 null 时不添加到请求体）
        $this->assertEmpty($decodedBody);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('env', $query);
        $this->assertEquals(1, $query['env']); // 应该使用默认环境
    }

    public function testQueryAdverFunds()
    {
        $client = new Client($this->app);
        
        $params = [
            'start_time' => '2023-01-01',
            'end_time' => '2023-01-31',
            'offset' => 0,
            'limit' => 20,
        ];
        
        $result = $client->queryAdverFunds($params);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/query_adver_funds', $request->getUri()->getPath());
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($params['start_time'], $decodedBody['start_time']);
        $this->assertEquals($params['end_time'], $decodedBody['end_time']);
        $this->assertEquals($params['offset'], $decodedBody['offset']);
        $this->assertEquals($params['limit'], $decodedBody['limit']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('env', $query);
        $this->assertEquals(1, $query['env']);
        
        // 验证不包含 signature（因为不是用户签名接口）
        $this->assertArrayNotHasKey('signature', $query);
    }

    public function testCreateFundsBill()
    {
        $client = new Client($this->app);
        
        $params = [
            'amount' => 10000,
            'desc' => 'Test fund creation',
            'bill_no' => 'bill_123',
        ];
        
        $result = $client->createFundsBill($params);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/create_funds_bill', $request->getUri()->getPath());
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($params['amount'], $decodedBody['amount']);
        $this->assertEquals($params['desc'], $decodedBody['desc']);
        $this->assertEquals($params['bill_no'], $decodedBody['bill_no']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('env', $query);
        $this->assertEquals(1, $query['env']);
        
        // 验证不包含 signature（因为不是用户签名接口）
        $this->assertArrayNotHasKey('signature', $query);
    }

    public function testBindTransferAccount()
    {
        $client = new Client($this->app);
        
        $params = [
            'account_type' => 1,
            'account_no' => 'account_123',
            'account_name' => 'Test Account',
        ];
        
        $result = $client->bindTransferAccount($params);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/bind_transfer_account', $request->getUri()->getPath());
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($params['account_type'], $decodedBody['account_type']);
        $this->assertEquals($params['account_no'], $decodedBody['account_no']);
        $this->assertEquals($params['account_name'], $decodedBody['account_name']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('env', $query);
        $this->assertEquals(1, $query['env']);
        
        // 验证不包含 signature（因为不是用户签名接口）
        $this->assertArrayNotHasKey('signature', $query);
    }

    public function testQueryFundsBill()
    {
        $client = new Client($this->app);
        
        $params = [
            'start_time' => '2023-01-01',
            'end_time' => '2023-01-31',
            'offset' => 0,
            'limit' => 20,
        ];
        
        $result = $client->queryFundsBill($params);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/query_funds_bill', $request->getUri()->getPath());
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($params['start_time'], $decodedBody['start_time']);
        $this->assertEquals($params['end_time'], $decodedBody['end_time']);
        $this->assertEquals($params['offset'], $decodedBody['offset']);
        $this->assertEquals($params['limit'], $decodedBody['limit']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('env', $query);
        $this->assertEquals(1, $query['env']);
        
        // 验证不包含 signature（因为不是用户签名接口）
        $this->assertArrayNotHasKey('signature', $query);
    }

    public function testQueryRecoverBill()
    {
        $client = new Client($this->app);
        
        $params = [
            'start_time' => '2023-01-01',
            'end_time' => '2023-01-31',
            'offset' => 0,
            'limit' => 20,
        ];
        
        $result = $client->queryRecoverBill($params);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/query_recover_bill', $request->getUri()->getPath());
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($params['start_time'], $decodedBody['start_time']);
        $this->assertEquals($params['end_time'], $decodedBody['end_time']);
        $this->assertEquals($params['offset'], $decodedBody['offset']);
        $this->assertEquals($params['limit'], $decodedBody['limit']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('env', $query);
        $this->assertEquals(1, $query['env']);
        
        // 验证不包含 signature（因为不是用户签名接口）
        $this->assertArrayNotHasKey('signature', $query);
    }

    public function testDownloadAdverfundsOrder()
    {
        $client = new Client($this->app);
        
        $fundId = 'fund_123';
        
        $result = $client->downloadAdverfundsOrder($fundId);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/download_adverfunds_order', $request->getUri()->getPath());
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($fundId, $decodedBody['fund_id']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('env', $query);
        $this->assertEquals(1, $query['env']);
        
        // 验证不包含 signature（因为不是用户签名接口）
        $this->assertArrayNotHasKey('signature', $query);
    }

    public function testDownloadAdverfundsOrderWithCustomEnv()
    {
        $client = new Client($this->app);
        
        $fundId = 'fund_456';
        $env = 0; // 自定义环境
        
        $result = $client->downloadAdverfundsOrder($fundId, $env);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($fundId, $decodedBody['fund_id']);
        $this->assertEquals($env, $decodedBody['env']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('env', $query);
        $this->assertEquals(0, $query['env']); // 应该使用自定义环境
    }

    public function testDownloadAdverfundsOrderWithNullEnv()
    {
        $client = new Client($this->app);
        
        $fundId = 'fund_789';
        
        $result = $client->downloadAdverfundsOrder($fundId, null);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($fundId, $decodedBody['fund_id']);
        $this->assertArrayNotHasKey('env', $decodedBody);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('env', $query);
        $this->assertEquals(1, $query['env']); // 应该使用默认环境
    }
}