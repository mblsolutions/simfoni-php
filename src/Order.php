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
    public function cancel(string $id): array
    {
        return $this->getApiRequestor()->deleteRequest('/api/order/'.$id);
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
     * Show Product
     *
     * @param  string  $id
     * @return array
     */
    public function show(string $id): array
    {
        return $this->getApiRequestor()->getRequest('/api/order/'.$id);
    }

    /**
     * @param  array  $params
     * @return array
     */
    public function all(array $params = []): array
    {
        return $this->getApiRequestor()->getRequest('/api/order', $params);
    }

    /**
     * @param $base64Key
     * @param $encryptedString
     * @param  string  $method
     * @return false|string
     */
    public function decrypt(string $base64Key, string $encryptedString, $method = 'AES-256-CBC')
    {
        $key = base64_decode($base64Key);

        $encryptObject = base64_decode($encryptedString);

        $encryptArray = json_decode($encryptObject, false);
        $iv = base64_decode($encryptArray->iv);
        $encryptObjectValue = $encryptArray->value;

        return openssl_decrypt($encryptObjectValue, $method, $key, 0, $iv);
    }

}