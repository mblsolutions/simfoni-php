<?php

namespace MBLSolutions\Simfoni\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use MBLSolutions\Simfoni\Api\ApiRequestor;
use MBLSolutions\Simfoni\Simfoni;
use ReflectionClass;
use ReflectionException;

class TestCase extends \PHPUnit\Framework\TestCase
{

    /** @var Response $mockedResponse */
    private $mockedResponse;

    /**
     * Reset an Inspired Deck Property to be NULL
     *
     * @param string $property
     */
    protected function unsetSimfoniProperty(string $property): void
    {
        try {

            $reflectionClass = new ReflectionClass(Simfoni::class);

            $reflectedProperty = $reflectionClass->getProperty($property);
            $reflectedProperty->setAccessible(true);
            $reflectedProperty->setValue(null);

        } catch (ReflectionException $exception) {
            $this->fail('Unable to reset Inspired Deck property `' . $property . '`');
        }
    }

    /**
     * Mock Expected HTTP Response
     *
     * @param array $response
     * @param int $code
     * @param array|null $headers
     */
    protected function mockExpectedHttpResponse(array $response, int $code = 200, array $headers = null): void
    {
        $this->mockedResponse = new Response(
            $code,
            $headers ?? ['Content-Type' => 'application/json'],
            json_encode($response)
        );

        $mock = new MockHandler([
            $this->mockedResponse
        ]);

        $client = new Client([
            'handler' => HandlerStack::create($mock)
        ]);

        ApiRequestor::setHttpClient($client);
    }

    /**
     * Get the Last Mocked Response Body
     *
     * @return array
     */
    protected function getMockedResponseBody(): array
    {
        return json_decode($this->mockedResponse->getBody(), true);
    }

}