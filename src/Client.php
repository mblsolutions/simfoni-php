<?php

namespace MBLSolutions\Simfoni;

use MBLSolutions\Simfoni\Api\ApiResource;

class Client extends ApiResource
{

    /**
     * Show Client
     *
     * @param  string  $urn
     * @return array
     */
    public function show(string $urn): array
    {
        return $this->getApiRequestor()->getRequest('/api/client/'.$urn);
    }

    /**
     * Show all Clients
     *
     * @return array
     */
    public function all(): array
    {
        return $this->getApiRequestor()->getRequest('/api/client');
    }

}