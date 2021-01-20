<?php

namespace MBLSolutions\Simfoni\Tests\Simfoni\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use MBLSolutions\Simfoni\Api\ApiRequestor;
use MBLSolutions\Simfoni\Simfoni;
use MBLSolutions\Simfoni\Tests\Stubs\HttpResponseStubs;
use MBLSolutions\Simfoni\Tests\TestCase;

class ApiRequestorTest extends TestCase
{

    /** @test */
    public function can_create_a_new_api_requestor_instance()
    {
        $guzzle = new Client;

        $apiRequestor = new ApiRequestor($guzzle);

        $this->assertInstanceOf(ApiRequestor::class, $apiRequestor);
    }

    /** @test **/
    public function default_request_headers()
    {
        $reflection = new \ReflectionClass(ApiRequestor::class);

        $defaultHeaders = $reflection->getMethod('defaultHeaders');
        $defaultHeaders->setAccessible(true);

        $guzzle = new Client;

        $this->assertEquals([
            'User-Agent' => Simfoni::AGENT . '/' . Simfoni::VERSION,
            'Accept'     => 'application/json',
        ], $defaultHeaders->invoke(new ApiRequestor($guzzle)));
    }

    /** @test */
    public function authenticated_request_headers()
    {
        $reflection = new \ReflectionClass(ApiRequestor::class);

        $defaultHeaders = $reflection->getMethod('authenticatedHeaders');
        $defaultHeaders->setAccessible(true);

        $guzzle = new Client;

        Simfoni::setToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjBmOGMwNDAxZDAy');

        $this->assertEquals([
            'User-Agent' => Simfoni::AGENT . '/' . Simfoni::VERSION,
            'Accept'     => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjBmOGMwNDAxZDAy'
        ], $defaultHeaders->invoke(new ApiRequestor($guzzle)));
    }

    /** @test **/
    public function can_get_http_client()
    {
        $apiRequestor = new ApiRequestor(new Client);

        $this->assertInstanceOf(Client::class, $apiRequestor->getHttpClient());
        $this->assertInstanceOf(Client::class, $apiRequestor->getHttpClient());
    }

    /** @test **/
    public function can_set_a_new_http_client()
    {
        $httpClient = new Client;

        $apiRequestor = new ApiRequestor($httpClient);

        $newHttpClient = new Client;

        ApiRequestor::setHttpClient($newHttpClient);

        $this->assertNotSame($apiRequestor->getHttpClient(), $httpClient);
        $this->assertSame($apiRequestor->getHttpClient(), $newHttpClient);
    }

    /** @test **/
    public function can_make_a_http_request()
    {
        $mock = new MockHandler([
            HttpResponseStubs::success()
        ]);

        $guzzle = new Client([
            'handler' => HandlerStack::create($mock)
        ]);

        $reflection = new \ReflectionClass(ApiRequestor::class);

        $method = $reflection->getMethod('makeHttpRequest');
        $method->setAccessible(true);

        $response = $method->invoke(new ApiRequestor($guzzle), 'post', 'brand', [
            'name' => 'Test Brand',
            'active' => true,
            'programme_manager_name' => 'John Doe',
            'programme_manager_email' => 'john.doe@example.com'
        ]);

        $this->assertIsArray($response);
    }

    /** @test **/
    public function can_make_a_http_get_request()
    {
        $mock = new MockHandler([
            HttpResponseStubs::success()
        ]);

        $guzzle = new Client([
            'handler' => HandlerStack::create($mock)
        ]);

        $apiRequestor = new ApiRequestor($guzzle);

        $response = $apiRequestor->getRequest('brand/1');

        $this->assertEquals([
            'data' => [
                'id' => 1,
                'name' => 'Test Brand',
                'active' => true
            ]
        ], $response);
    }
    
    /** @test **/
    public function can_make_a_http_post_request()
    {
        $mock = new MockHandler([
            HttpResponseStubs::success()
        ]);

        $guzzle = new Client([
            'handler' => HandlerStack::create($mock)
        ]);

        $apiRequestor = new ApiRequestor($guzzle);

        $response = $apiRequestor->postRequest('brand', [
            'name' => 'Test Brand',
            'active' => true,
            'programme_manager_name' => 'John Doe',
            'programme_manager_email' => 'john.doe@example.com'
        ]);

        $this->assertEquals([
            'data' => [
                'id' => 1,
                'name' => 'Test Brand',
                'active' => true
            ]
        ], $response);
    }

    /** @test **/
    public function can_make_a_http_patch_request()
    {
        $mock = new MockHandler([
            HttpResponseStubs::success()
        ]);

        $guzzle = new Client([
            'handler' => HandlerStack::create($mock)
        ]);

        $apiRequestor = new ApiRequestor($guzzle);

        $response = $apiRequestor->patchRequest('brand/1', [
            'name' => 'Test Brand',
            'active' => true
        ]);

        $this->assertEquals([
            'data' => [
                'id' => 1,
                'name' => 'Test Brand',
                'active' => true
            ]
        ], $response);
    }

    /** @test **/
    public function can_make_a_http_delete_request()
    {
        $mock = new MockHandler([
            HttpResponseStubs::success()
        ]);

        $guzzle = new Client([
            'handler' => HandlerStack::create($mock)
        ]);

        $apiRequestor = new ApiRequestor($guzzle);

        $response = $apiRequestor->deleteRequest('brand/1');

        $this->assertEquals([
            'data' => [
                'id' => 1,
                'name' => 'Test Brand',
                'active' => true
            ]
        ], $response);
    }

}