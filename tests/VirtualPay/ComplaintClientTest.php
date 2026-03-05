<?php

namespace Moonpie\EasyWechat\VirtualPay\Tests;

use PHPUnit\Framework\TestCase;
use Moonpie\EasyWechat\VirtualPay\Complaint\Client;
use EasyWeChat\Kernel\ServiceContainer;
use EasyWeChat\Kernel\Contracts\AccessTokenInterface;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;

class ComplaintClientTest extends TestCase
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

    public function testGetComplaintList()
    {
        $client = new Client($this->app);
        
        $params = [
            'start_time' => '2023-01-01',
            'end_time' => '2023-01-31',
            'offset' => 0,
            'limit' => 20,
        ];
        
        $result = $client->getComplaintList($params);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/get_complaint_list', $request->getUri()->getPath());
        
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

    public function testGetComplaintDetail()
    {
        $client = new Client($this->app);
        
        $complaintId = 'complaint_123';
        
        $result = $client->getComplaintDetail($complaintId);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/get_complaint_detail', $request->getUri()->getPath());
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($complaintId, $decodedBody['complaint_id']);
        
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

    public function testGetComplaintDetailWithCustomEnv()
    {
        $client = new Client($this->app);
        
        $complaintId = 'complaint_456';
        $env = 0; // 自定义环境
        
        $result = $client->getComplaintDetail($complaintId, $env);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($complaintId, $decodedBody['complaint_id']);
        $this->assertEquals($env, $decodedBody['env']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('env', $query);
        $this->assertEquals(0, $query['env']); // 应该使用自定义环境
    }

    public function testGetNegotiationHistory()
    {
        $client = new Client($this->app);
        
        $complaintId = 'complaint_789';
        
        $result = $client->getNegotiationHistory($complaintId);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/get_negotiation_history', $request->getUri()->getPath());
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($complaintId, $decodedBody['complaint_id']);
        $this->assertEquals(0, $decodedBody['offset']); // 默认值
        $this->assertEquals(20, $decodedBody['limit']); // 默认值
        
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

    public function testGetNegotiationHistoryWithCustomParams()
    {
        $client = new Client($this->app);
        
        $complaintId = 'complaint_000';
        $offset = 10;
        $limit = 50;
        $env = 0; // 自定义环境
        
        $result = $client->getNegotiationHistory($complaintId, $offset, $limit, $env);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($complaintId, $decodedBody['complaint_id']);
        $this->assertEquals($offset, $decodedBody['offset']);
        $this->assertEquals($limit, $decodedBody['limit']);
        $this->assertEquals($env, $decodedBody['env']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('env', $query);
        $this->assertEquals(0, $query['env']); // 应该使用自定义环境
    }

    public function testResponseComplaint()
    {
        $client = new Client($this->app);
        
        $complaintId = 'complaint_111';
        $responseContent = 'This is a response to the complaint';
        
        $result = $client->responseComplaint($complaintId, $responseContent);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/response_complaint', $request->getUri()->getPath());
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($complaintId, $decodedBody['complaint_id']);
        $this->assertEquals($responseContent, $decodedBody['response_content']);
        $this->assertEquals([], $decodedBody['response_images']); // 默认值
        
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

    public function testResponseComplaintWithImagesAndCustomEnv()
    {
        $client = new Client($this->app);
        
        $complaintId = 'complaint_222';
        $responseContent = 'This is a response with images';
        $responseImages = ['image_1', 'image_2'];
        $env = 0; // 自定义环境
        
        $result = $client->responseComplaint($complaintId, $responseContent, $responseImages, $env);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($complaintId, $decodedBody['complaint_id']);
        $this->assertEquals($responseContent, $decodedBody['response_content']);
        $this->assertEquals($responseImages, $decodedBody['response_images']);
        $this->assertEquals($env, $decodedBody['env']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('env', $query);
        $this->assertEquals(0, $query['env']); // 应该使用自定义环境
    }

    public function testCompleteComplaint()
    {
        $client = new Client($this->app);
        
        $complaintId = 'complaint_333';
        
        $result = $client->completeComplaint($complaintId);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/complete_complaint', $request->getUri()->getPath());
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($complaintId, $decodedBody['complaint_id']);
        
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

    public function testCompleteComplaintWithCustomEnv()
    {
        $client = new Client($this->app);
        
        $complaintId = 'complaint_444';
        $env = 0; // 自定义环境
        
        $result = $client->completeComplaint($complaintId, $env);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($complaintId, $decodedBody['complaint_id']);
        $this->assertEquals($env, $decodedBody['env']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('env', $query);
        $this->assertEquals(0, $query['env']); // 应该使用自定义环境
    }

    public function testUploadVpFile()
    {
        $client = new Client($this->app);
        
        $params = [
            'base64_img' => 'base64_encoded_image_data',
            'file_name' => 'test_image.jpg',
        ];
        
        $result = $client->uploadVpFile($params);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/upload_vp_file', $request->getUri()->getPath());
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($params['base64_img'], $decodedBody['base64_img']);
        $this->assertEquals($params['file_name'], $decodedBody['file_name']);
        
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

    public function testGetUploadFileSign()
    {
        $client = new Client($this->app);
        
        $wxpayUrl = 'https://api.mch.weixin.qq.com/v3/merchant-service/images/test_image';
        
        $result = $client->getUploadFileSign($wxpayUrl);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证请求 URL - 检查路径部分，因为Mock请求可能有不同的格式
        $this->assertEquals('/xpay/get_upload_file_sign', $request->getUri()->getPath());
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($wxpayUrl, $decodedBody['wxpay_url']);
        $this->assertFalse($decodedBody['convert_cos']); // 默认值
        
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

    public function testGetUploadFileSignWithAllParams()
    {
        $client = new Client($this->app);
        
        $wxpayUrl = 'https://api.mch.weixin.qq.com/v3/merchant-service/images/test_image_2';
        $convertCos = true;
        $complaintId = 'complaint_555';
        $env = 0; // 自定义环境
        
        $result = $client->getUploadFileSign($wxpayUrl, $convertCos, $complaintId, $env);
        
        $this->assertNotNull($result);
        
        // 验证请求历史
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求体
        $requestBody = $request->getBody()->getContents();
        $decodedBody = json_decode($requestBody, true);
        
        $this->assertEquals($wxpayUrl, $decodedBody['wxpay_url']);
        $this->assertTrue($decodedBody['convert_cos']);
        $this->assertEquals($complaintId, $decodedBody['complaint_id']);
        $this->assertEquals($env, $decodedBody['env']);
        
        // 验证查询参数包含签名
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('env', $query);
        $this->assertEquals(0, $query['env']); // 应该使用自定义环境
    }
}