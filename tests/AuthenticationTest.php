<?php

namespace MBLSolutions\Simfoni\Tests;

use MBLSolutions\Simfoni\Authentication;
use MBLSolutions\Simfoni\Exceptions\AuthenticationException;
use MBLSolutions\Simfoni\Simfoni;

class AuthenticationTest extends TestCase
{
    /** @var Authentication $authentication */
    protected $authentication;

    /** {@inheritdoc} **/
    public function setUp()
    {
        parent::setUp();

        $this->authentication = new Authentication;
    }

    /** @test **/
    public function oauth_authenticate_using_password_grant()
    {
        $this->mockExpectedHttpResponse([
            'token_type' => 'Bearer',
            'expires_in' => 31622400,
            'access_token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjBmOGMwNDAxZDAy',
            'refresh_token' => 'def5020002eca9ac7875d5d800c195024d7fb702535c0d30a0',
            'user' => [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'role' => 'programme_manager'
            ]
        ]);

        $response = $this->authentication->password(1, 'auth-secret', 'john.doe@exmaple.com', 'password');

        self::assertEquals([
            'token_type' => 'Bearer',
            'expires_in' => 31622400,
            'access_token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjBmOGMwNDAxZDAy',
            'refresh_token' => 'def5020002eca9ac7875d5d800c195024d7fb702535c0d30a0',
            'user' => [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'role' => 'programme_manager'
            ]
        ], $response);
    }

    /** @test */
    public function successful_oauth_password_grant_authentication_resets_bearer_token()
    {
        $this->mockExpectedHttpResponse([
            'token_type' => 'Bearer',
            'expires_in' => 31622400,
            'access_token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjBmOGMwNDAxZDAy',
            'refresh_token' => 'def5020002eca9ac7875d5d800c195024d7fb702535c0d30a0',
            'user' => [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'role' => 'programme_manager'
            ]
        ]);

        $this->authentication->password(1, 'auth-secret', 'john.doe@exmaple.com', 'password');

        self::assertEquals('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjBmOGMwNDAxZDAy', Simfoni::getToken());
    }

    /** @test */
    public function oauth_password_grant_authentication_using_invalid_credentials()
    {
        $this->expectException(AuthenticationException::class);

        $this->expectExceptionCode(401);
        $this->expectExceptionMessage('The user credentials were incorrect.');

        $this->mockExpectedHttpResponse([
            'error' => 'invalid_credentials',
            'error_description' => 'The user credentials were incorrect.',
            'message' => 'The user credentials were incorrect.'
        ], 401);

        $this->authentication->password(1, 'auth-secret', 'john.doe@exmaple.com', 'password');
    }

    /** @test */
    public function oauth_password_grant_authentication_using_invalid_client()
    {
        $this->expectException(AuthenticationException::class);

        $this->expectExceptionCode(401);
        $this->expectExceptionMessage('Client authentication failed');

        $this->mockExpectedHttpResponse([
            'error' => 'invalid_client',
            'error_description' => 'Client authentication failed',
            'message' => 'Client authentication failed',
        ], 401);

        $this->authentication->password(1, 'auth-secret', 'john.doe@exmaple.com', 'password');
    }

}