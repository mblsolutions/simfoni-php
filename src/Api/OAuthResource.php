<?php

namespace MBLSolutions\Simfoni\Api;

use GuzzleHttp\Client;
use MBLSolutions\Simfoni\Simfoni;

abstract class OAuthResource extends ApiResource
{

    /**
     * Inspired Deck OAuth Resource
     */
    public function __construct()
    {
        parent::__construct();

        $client = new Client([
            'base_uri' => Simfoni::getBaseUri(),
        ]);

        $this->setApiRequestor(new ApiRequestor($client));
    }

}