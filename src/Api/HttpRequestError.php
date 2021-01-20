<?php

namespace MBLSolutions\Simfoni\Api;

use GuzzleHttp\Exception\ClientException;
use MBLSolutions\Simfoni\Exceptions\AuthenticationException;
use MBLSolutions\Simfoni\Exceptions\NotFoundException;
use MBLSolutions\Simfoni\Exceptions\PermissionDeniedException;
use MBLSolutions\Simfoni\Exceptions\ValidationException;

class HttpRequestError
{

    /** @var int */
    public const HTTP_UNAUTHORIZED = 401;

    /** @var int */
    public const HTTP_FORBIDDEN = 403;

    /** @var int */
    public const HTTP_NOT_FOUND = 404;

    /** @var int */
    public const HTTP_UNPROCESSABLE_ENTITY = 422;

    /**
     * Handle HTTP Client Request Error
     *
     * @param ClientException $exception
     */
    public static function handle(ClientException $exception)
    {
        if ($exception->getCode() === self::HTTP_UNAUTHORIZED) {
            static::throwException(AuthenticationException::class, $exception);
        }

        if ($exception->getCode() === self::HTTP_FORBIDDEN) {
            static::throwException(PermissionDeniedException::class, $exception);
        }

        if ($exception->getCode() === self::HTTP_NOT_FOUND) {
            static::throwException(NotFoundException::class, $exception);
        }

        if ($exception->getCode() === self::HTTP_UNPROCESSABLE_ENTITY) {
            static::throwException(ValidationException::class, $exception);
        }

        throw $exception;
    }

    /**
     * Throw an Exception
     *
     * @param string $type
     * @param $exception
     * @throws mixed
     */
    private static function throwException(string $type, ClientException $exception)
    {
        $response = $exception->getResponse();

        if ($response) {
            $message = $response->getBody()->getContents();
        }

        throw new $type($message ?? 'Received an empty response', $exception->getCode(), $exception->getPrevious());
    }

}