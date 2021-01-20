<?php

namespace MBLSolutions\Simfoni\Tests\Stubs;

use GuzzleHttp\Psr7\Response;

class HttpResponseStubs
{

    /**
     * Successful HTTP Response Stub
     *
     * @param array|null $body
     * @return Response
     */
    public static function success(array $body = null): Response
    {
        $default = [
            'data' => [
                'id' => 1,
                'name' => 'Test Brand',
                'active' => true
            ]
        ];

        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode($body ?? $default)
        );
    }

    /**
     * Unauthorized HTTP Response Stub
     *
     * @param array|null $body
     * @return Response
     */
    public static function unauthorized(array $body = null): Response
    {
        $default = [
            'message' => 'Unauthenticated.'
        ];

        return new Response(
            401,
            ['Content-Type' => 'application/json'],
            json_encode($body ?? $default)
        );
    }

    /**
     * Forbidden HTTP Response Stub
     *
     * @param array|null $body
     * @return Response
     */
    public static function forbidden(array $body = null): Response
    {
        $default = [
            'message' => 'You do not have permission to access this resource.'
        ];

        return new Response(
            403,
            ['Content-Type' => 'application/json'],
            json_encode($body ?? $default)
        );
    }

    /**
     * Unprocessable Entity Http Response Stub
     *
     * @param array|null $body
     * @return Response
     */
    public static function unprocessableEntity(array $body = null): Response
    {
        $default = [
            'message' => 'The given data was invalid.',
            'errors' => [
                'name' => [
                    'This brand name has already been taken.'
                ],
                'programme_manager_email' => [
                    'This email address has already been taken.'
                ]
            ]
        ];

        return new Response(
            422,
            ['Content-Type' => 'application/json'],
            json_encode($body ?? $default)
        );
    }

}