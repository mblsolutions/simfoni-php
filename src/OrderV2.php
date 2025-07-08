<?php

namespace MBLSolutions\Simfoni;

class OrderV2 extends Order
{
    protected $version = "v2/";

    public function cancelOrderItem(array $params = [], array $headers = []): array
    {
        return $this->getApiRequestor()->deleteJson('/api/v2/order/item', $params, array_merge(
            $this->getApiRequestor()->authenticatedHeaders(),
            $headers
        ));
    }
}
