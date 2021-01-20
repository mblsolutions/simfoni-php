<?php

namespace MBLSolutions\Simfoni;

use MBLSolutions\Simfoni\Api\ApiResource;

class Product extends ApiResource
{

    /**
     * Show Product
     *
     * @param  int  $id
     * @return array
     */
    public function show(int $id): array
    {
        return $this->getApiRequestor()->getRequest('/api/account/product/'.$id);
    }

    /**
     * Show all Products
     *
     * @return array
     */
    public function all(): array
    {
        return $this->getApiRequestor()->getRequest('/api/account/product');
    }

}