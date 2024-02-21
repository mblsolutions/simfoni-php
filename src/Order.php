<?php

namespace MBLSolutions\Simfoni;

use MBLSolutions\Simfoni\Api\ApiResource;

class Order extends ApiResource
{

    /**
     * Create an Order
     *
     * @param  array  $params
     * @return array
     */
    public function create(array $params = []): array
    {
        return $this->getApiRequestor()->postRequest('/api/order/', $params);
    }



    /**
     * Cancel an Order
     *
     * @param  string  $id
     * @return array
     */
    public function cancel(string $id, string $type = 'id'): array
    {
        return $this->getApiRequestor()->deleteRequest('/api/order/'.$id, ['type' => $type]);
    }

    /**
     * @param  array  $params
     * @return array
     */
    public function search(array $params = []): array
    {
        return $this->getApiRequestor()->postRequest('/api/search/order', $params);
    }

    /**
     * Show Order
     *
     * @param string $id
     * @param string $type
     * @return array
     */
    public function show(string $id, string $type = 'id'): array
    {
        return $this->getApiRequestor()->getRequest('/api/order/'.$id, ['type' => $type]);
    }

    /**
     * @param  array  $params
     * @return array
     */
    public function all(array $params = []): array
    {
        return $this->getApiRequestor()->getRequest('/api/order', $params);
    }

}