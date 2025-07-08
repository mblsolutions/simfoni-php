<?php

namespace MBLSolutions\Simfoni;

class OrderV2 extends Order
{
    protected $version = "v2/";

    public function cancelLink(string $url, array $params = [], array $headers = []): array
    {
        return $this->getApiRequestor()->deleteRequest('/api/v2/order/link', array_merge([
            'urls' => [$url]
        ], $params), $headers);
    }
}
