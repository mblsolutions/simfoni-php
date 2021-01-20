<?php

namespace MBLSolutions\Simfoni\Exceptions;

use Exception;
use GuzzleHttp\Exception\ServerException;

class ReportRenderException extends Exception
{
    /** @var array|null $response */
    protected $response;

    /**
     * Render Report Exception
     * @param Exception $exception
     */
    public function __construct(Exception $exception)
    {
        $this->parse($exception);

        parent::__construct($exception->getMessage(), $exception->getCode());
    }

    /**
     * Parse the Error extracting response data
     *
     * @param Exception $exception
     */
    protected function parse(Exception $exception)
    {
        if ($exception instanceof ServerException) {
            $this->response = json_decode($exception->getResponse()->getBody()->getContents(), true);
        }
    }

    /**
     * Get Response
     *
     * @return array|null
     */
    public function getResponse()
    {
        return $this->response;
    }

}