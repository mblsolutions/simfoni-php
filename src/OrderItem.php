<?php

namespace MBLSolutions\Simfoni;

use MBLSolutions\Simfoni\Api\ApiResource;

class OrderItem extends ApiResource
{

    /**
     * Show Items for Order
     *
     * @param  string  $orderId
     * @return array
     */
    public function show(string $orderId): array
    {
        return $this->getApiRequestor()->getRequest('/api/order/'.$orderId.'/items');
    }

    /**
     * Show issuance information for order
     *
     * @param  string  $hash
     * @return array
     */
    public function info(string $hash): array
    {
        return $this->getApiRequestor()->getRequest('/api/order/'.$hash.'/issuedinfo');
    }

}