<?php

namespace MBLSolutions\Simfoni\Api;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use MBLSolutions\Simfoni\Simfoni;

abstract class ApiResource
{
    /** @var ApiRequestor $apiRequestor */
    private $apiRequestor;

    /**
     * Inspired Deck API Resource
     *
     * @param ClientInterface|null $client
     */
    public function __construct(ClientInterface $client = null)
    {
        if ($client === null) {
            $client = new Client([
                'base_uri' => Simfoni::getBaseUri()
            ]);
        }

        $this->apiRequestor = new ApiRequestor($client);
    }

    /**
     * Get an API Requestor Instance
     *
     * @return ApiRequestor
     */
    public function getApiRequestor(): ApiRequestor
    {
        return $this->apiRequestor;
    }

    /**
     * Set a new instance of the API Requestor
     *
     * @param ApiRequestor $apiRequestor
     * @return ApiRequestor
     */
    public function setApiRequestor(ApiRequestor $apiRequestor): ApiRequestor
    {
        $this->apiRequestor = $apiRequestor;

        return $this->apiRequestor;
    }

}