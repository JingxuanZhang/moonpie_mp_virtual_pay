<?php

namespace Moonpie\EasyWechat\VirtualPay\Tests;

use PHPUnit\Framework\TestCase;
use Moonpie\EasyWechat\VirtualPay\BasicClient;
use EasyWeChat\Kernel\ServiceContainer;
use EasyWeChat\Kernel\Contracts\AccessTokenInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;

class BasicClientTest extends TestCase
{
    private $app;
    private $mockHandler;
    private $httpClient;

    protected function setUp(): void
    {
        parent::setUp();
        
        // 创建模拟的 ServiceContainer
        $this->app = new ServiceContainer([
            'env' => 1,
            'app_key' => 'test_app_key_123456',
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
        $history = [];
        $historyMiddleware = \GuzzleHttp\Middleware::history($history);
        $handlerStack->push($historyMiddleware);
        
        $this->httpClient = new Client(['handler' => $handlerStack]);
        $this->app['http_client'] = $this->httpClient;
        
        // 保存历史记录以便测试使用
        $this->history = &$history;
        
        // 模拟 access_token 服务
        $mockAccessToken = $this->createMock(AccessTokenInterface::class);
        $this->app['access_token'] = $mockAccessToken;
    }
    
    private $history = [];

    public function testGeneratePaySig()
    {
        $mockAccessToken = $this->createMock(AccessTokenInterface::class);
        $client = new BasicClient($this->app, $mockAccessToken);
        
        $uri = '/xpay/test';
        $postBody = '{"key": "value"}';
        $appKey = 'test_app_key_123456';
        
        $expectedSig = hash_hmac('sha256', $uri . '&' . $postBody, $appKey);
        $actualSig = $this->invokeMethod($client, 'generatePaySig', [$uri, $postBody, $appKey]);
        
        $this->assertEquals($expectedSig, $actualSig);
    }

    public function testGeneratePaySigWithEmptyBody()
    {
        $mockAccessToken = $this->createMock(AccessTokenInterface::class);
        $client = new BasicClient($this->app, $mockAccessToken);
        
        $uri = '/xpay/test';
        $postBody = '';
        $appKey = 'test_app_key_123456';
        
        $expectedSig = hash_hmac('sha256', $uri . '&' . $postBody, $appKey);
        $actualSig = $this->invokeMethod($client, 'generatePaySig', [$uri, $postBody, $appKey]);
        
        $this->assertEquals($expectedSig, $actualSig);
    }

    public function testGenerateSignature()
    {
        $mockAccessToken = $this->createMock(AccessTokenInterface::class);
        $client = new BasicClient($this->app, $mockAccessToken);
        
        $postBody = '{"key": "value"}';
        $sessionKey = 'test_session_key_789';
        
        $expectedSig = hash_hmac('sha256', $postBody, $sessionKey);
        $actualSig = $this->invokeMethod($client, 'generateSignature', [$postBody, $sessionKey]);
        
        $this->assertEquals($expectedSig, $actualSig);
    }

    public function testGenerateSignatureWithEmptyBody()
    {
        $mockAccessToken = $this->createMock(AccessTokenInterface::class);
        $client = new BasicClient($this->app, $mockAccessToken);
        
        $postBody = '';
        $sessionKey = 'test_session_key_789';
        
        $expectedSig = hash_hmac('sha256', $postBody, $sessionKey);
        $actualSig = $this->invokeMethod($client, 'generateSignature', [$postBody, $sessionKey]);
        
        $this->assertEquals($expectedSig, $actualSig);
    }

    public function testRequestAddsPaySigAndEnv()
    {
        $mockAccessToken = $this->createMock(AccessTokenInterface::class);
        $client = new BasicClient($this->app, $mockAccessToken);
        
        $url = 'https://api.example.com/xpay/test';
        $options = [
            'json' => ['key' => 'value']
        ];
        
        $result = $client->request($url, 'POST', $options);
        
        // 验证模拟处理器被调用
        $this->assertNotNull($result);
        
        // 检查请求是否被正确处理（通过检查模拟处理器的调用）
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证 URL 包含 pay_sig 和 env 参数
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('env', $query);
        $this->assertEquals(1, $query['env']);
    }

    public function testRequestWithDifferentBodyFormats()
    {
        $mockAccessToken = $this->createMock(AccessTokenInterface::class);
        $client = new BasicClient($this->app, $mockAccessToken);
        
        // 测试 json 格式
        $url = 'https://api.example.com/xpay/test';
        $options = [
            'json' => ['key' => 'value']
        ];
        
        $result = $client->request($url, 'POST', $options);
        $this->assertNotNull($result);
        
        // 测试 form_params 格式
        $options = [
            'form_params' => ['key' => 'value']
        ];
        
        $result = $client->request($url, 'POST', $options);
        $this->assertNotNull($result);
        
        // 测试 body 格式
        $options = [
            'body' => 'key=value&test=123'
        ];
        
        $result = $client->request($url, 'POST', $options);
        $this->assertNotNull($result);
    }

    public function testHttpPostJson()
    {
        $mockAccessToken = $this->createMock(AccessTokenInterface::class);
        $client = new BasicClient($this->app, $mockAccessToken);
        
        $url = 'https://api.example.com/xpay/test';
        $data = ['key' => 'value'];
        $query = ['param' => 'test'];
        $sessionKey = 'test_session_key_789';
        
        $result = $client->httpPostJson($url, $data, $query, $sessionKey);
        
        $this->assertNotNull($result);
        
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
        
        // 验证 URL 包含查询参数
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $queryParams);
        
        $this->assertArrayHasKey('param', $queryParams);
        $this->assertEquals('test', $queryParams['param']);
    }

    public function testHttpPostJsonWithNullSessionKey()
    {
        $mockAccessToken = $this->createMock(AccessTokenInterface::class);
        $client = new BasicClient($this->app, $mockAccessToken);
        
        $url = 'https://api.example.com/xpay/test';
        $data = ['key' => 'value'];
        $query = ['param' => 'test'];
        // sessionKey 为 null
        
        $result = $client->httpPostJson($url, $data, $query, null);
        
        $this->assertNotNull($result);
    }

    public function testHttpPost()
    {
        $mockAccessToken = $this->createMock(AccessTokenInterface::class);
        $client = new BasicClient($this->app, $mockAccessToken);
        
        $url = 'https://api.example.com/xpay/test';
        $data = ['key' => 'value'];
        $query = ['param' => 'test'];
        $sessionKey = 'test_session_key_789';
        
        $result = $client->httpPost($url, $data, $query, $sessionKey);
        
        $this->assertNotNull($result);
        
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证请求方法是 POST
        $this->assertEquals('POST', $request->getMethod());
    }

    public function testHttpPostWithNullSessionKey()
    {
        $mockAccessToken = $this->createMock(AccessTokenInterface::class);
        $client = new BasicClient($this->app, $mockAccessToken);
        
        $url = 'https://api.example.com/xpay/test';
        $data = ['key' => 'value'];
        $query = ['param' => 'test'];
        // sessionKey 为 null
        
        $result = $client->httpPost($url, $data, $query, null);
        
        $this->assertNotNull($result);
    }

    public function testRequestWithUrlContainingQueryParams()
    {
        $mockAccessToken = $this->createMock(AccessTokenInterface::class);
        $client = new BasicClient($this->app, $mockAccessToken);
        
        $url = 'https://api.example.com/xpay/test?existing=param';
        $options = [
            'json' => ['key' => 'value']
        ];
        
        $result = $client->request($url, 'POST', $options);
        
        $this->assertNotNull($result);
        
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证 URL 包含原始查询参数和新增的签名参数
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('existing', $query);
        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('env', $query);
        $this->assertEquals('param', $query['existing']);
    }

    public function testRequestWithUserSignature()
    {
        $mockAccessToken = $this->createMock(AccessTokenInterface::class);
        $client = new BasicClient($this->app, $mockAccessToken);
        
        $url = 'https://api.example.com/xpay/query_user_balance';
        $options = [
            'json' => ['user_id' => '123'],
            'session_key' => 'test_session_key_789'
        ];
        
        $result = $client->request($url, 'POST', $options);
        
        // 验证模拟处理器被调用
        $this->assertNotNull($result);
        
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证 URL 包含 pay_sig、env 和 signature 参数
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('env', $query);
        $this->assertArrayHasKey('signature', $query);
        $this->assertEquals(1, $query['env']);
        
        // 验证 session_key 不在 query 参数中（已被移除）
        $this->assertArrayNotHasKey('session_key', $query);
    }

    public function testRequestWithUserSignatureButNoSessionKey()
    {
        $mockAccessToken = $this->createMock(AccessTokenInterface::class);
        $client = new BasicClient($this->app, $mockAccessToken);
        
        $url = 'https://api.example.com/xpay/query_user_balance';
        $options = [
            'json' => ['user_id' => '123']
            // 注意：没有 session_key
        ];
        
        $result = $client->request($url, 'POST', $options);
        
        // 验证模拟处理器被调用
        $this->assertNotNull($result);
        
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证 URL 包含 pay_sig 和 env，但不包含 signature
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('env', $query);
        $this->assertArrayNotHasKey('signature', $query);
    }

    public function testRequestWithNonUserSignatureInterface()
    {
        $mockAccessToken = $this->createMock(AccessTokenInterface::class);
        $client = new BasicClient($this->app, $mockAccessToken);
        
        $url = 'https://api.example.com/xpay/other_interface';
        $options = [
            'json' => ['key' => 'value'],
            'session_key' => 'test_session_key_789'
        ];
        
        $result = $client->request($url, 'POST', $options);
        
        $this->assertNotNull($result);
        
        $this->assertCount(1, $this->history);
        $request = $this->history[0]['request'];
        
        // 验证 URL 包含 pay_sig 和 env，但不包含 signature（因为不是用户签名接口）
        $uri = $request->getUri();
        $queryString = $uri->getQuery();
        parse_str($queryString, $query);
        
        $this->assertArrayHasKey('pay_sig', $query);
        $this->assertArrayHasKey('env', $query);
        $this->assertArrayNotHasKey('signature', $query);
    }

    /**
     * 调用私有/受保护方法的辅助函数
     */
    private function invokeMethod($object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }
}
