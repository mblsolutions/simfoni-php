<?php

namespace MBLSolutions\Simfoni\Exceptions;

use Exception;
use Throwable;

class ValidationException extends Exception
{
    /** @var array */
    protected $json;

    /** @var $errors */
    protected $errors;

    /**
     * Throw a Validation Exception
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message, int $code, Throwable $previous = null)
    {
        $this->json = json_decode($message, true);

        if ($this->json) {
            $this->errors = $this->formatErrorDetails($this->json);
        }

        parent::__construct($this->json['message'] ?? $message, $code, $previous);
    }

    /**
     * Get the Error Message Body
     * 
     * @return array
     */
    public function getMessageBody(): array
    {
        return $this->json;
    }

    /**
     * Get Validation Errors
     *
     * @return array
     */
    public function getValidationErrors(): array
    {
        return $this->errors;
    }

    /**
     * Format Error Details
     *
     * @param array $json
     * @return array|mixed
     */
    private function formatErrorDetails(array $json = [])
    {
        return $json['errors'] ?? ['message' => [$json['message']]];
    }

}