<?php

namespace MBLSolutions\Simfoni;

use MBLSolutions\Simfoni\Api\ApiResource;

class Account extends ApiResource
{

    /**
     * Show Account
     *
     * @return array
     */
    public function show(): array
    {
        return $this->getApiRequestor()->getRequest('/api/account');
    }

}