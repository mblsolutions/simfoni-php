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

        $exceptionMessage = $this->formatErrorDetailsForExceptionMessage($this->json, $message);

        parent::__construct($exceptionMessage, $code, $previous);
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
    private function formatErrorDetailsForExceptionMessage(array $json = [], $message = null)
    {
        $default = $json['message'] ?? $message;

        $details = array_key_exists('errors', $json) ? [$default, $json['errors']] : ['message' => $default];

        return json_encode($details);
    }

    private function formatErrorDetails(array $json = [])
    {
        return $json['errors'] ?? ['message' => [$json['message']]];
    }

}
