<?php

namespace MBLSolutions\Simfoni;

use MBLSolutions\Simfoni\Api\ApiResource;

class IssuedInfo extends ApiResource
{

    /**
     * Show issuance information for order
     *
     * @param  string  $hash
     * @return array
     */
    public function show(string $hash): array
    {
        return $this->getApiRequestor()->getRequest('/api/order/'.$hash.'/issuedinfo');
    }

}