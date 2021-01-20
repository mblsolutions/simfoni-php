<?php

namespace MBLSolutions\Simfoni\Tests\Simfoni\Api;

use GuzzleHttp\Client;
use MBLSolutions\Simfoni\Api\ApiRequestor;
use MBLSolutions\Simfoni\Api\ApiResource;
use MBLSolutions\Simfoni\Tests\TestCase;

class ApiResourceTest extends TestCase
{
    
    /** @test **/
    public function can_get_api_requestor()
    {
        $stub = $this->getMockBuilder(ApiResource::class)
                     ->getMock();

        $this->assertInstanceOf(ApiRequestor::class, $stub->getApiRequestor());
    }

    /** @test **/
    public function can_set_api_requestor()
    {
        $stub = $this->getMockBuilder(ApiResource::class)
                     ->getMock();

        $newApiRequestor = new ApiRequestor(new Client);

        $this->assertInstanceOf(ApiRequestor::class, $stub->setApiRequestor($newApiRequestor));
    }

}