<?php

namespace MBLSolutions\Simfoni\Tests\Simfoni;

use MBLSolutions\Simfoni\Exceptions\MissingTokenException;
use MBLSolutions\Simfoni\Simfoni;
use MBLSolutions\Simfoni\Tests\TestCase;

class SimfoniTest extends TestCase
{

    /** @test **/
    public function can_get_package_version()
    {
        self::assertIsString(Simfoni::VERSION);
    }

    /** @test **/
    public function can_get_package_agent()
    {
        self::assertEquals('Simfoni-PHP', Simfoni::AGENT);
    }

    /** @test **/
    public function can_get_base_uri()
    {
        self::assertEquals('https://simfoni.co.uk', Simfoni::getBaseUri());
    }

    /** @test **/
    public function can_override_the_base_uri()
    {
        Simfoni::setBaseUri('http://localhost');

        self::assertEquals('http://localhost', Simfoni::getBaseUri());
    }

    /** @test **/
    public function can_set_bearer_token()
    {
        Simfoni::setToken('test_token');

        self::assertEquals('test_token', Simfoni::getToken());
    }

    /** @test **/
    public function can_set_a_new_bearer_token()
    {
        Simfoni::setToken('new_test_token');

        self::assertEquals('new_test_token', Simfoni::getToken());
    }

    /** @test **/
    public function exception_thrown_if_retrieving_bearer_token_that_is_set_to_null()
    {
        $this->expectException(MissingTokenException::class);
        $this->unsetSimfoniProperty('token');

        Simfoni::getToken();
    }

    /** @test **/
    public function can_get_verify_ssl(): void
    {
        self::assertTrue(Simfoni::getVerifySSL());
        self::assertIsBool(Simfoni::getVerifySSL());
    }

    /** @test **/
    public function can_set_verify_ssl(): void
    {
        Simfoni::setVerifySSL(false);

        self::assertFalse(Simfoni::getVerifySSL());
    }

}