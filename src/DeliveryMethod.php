<?php

namespace MBLSolutions\Simfoni;

use MBLSolutions\Simfoni\Api\ApiResource;

class DeliveryMethod extends ApiResource
{

    /**
     * Show Delivery Method
     *
     * @param  string  $id
     * @return array
     */
    public function show(string $id): array
    {
        return $this->getApiRequestor()->getRequest('/api/deliverymethod/'.$id);
    }

    /**
     * Show all Delivery Methods
     *
     * @return array
     */
    public function all(): array
    {
        return $this->getApiRequestor()->getRequest('/api/deliverymethod');
    }

}