<?php

namespace MBLSolutions\Simfoni;

use MBLSolutions\Simfoni\Api\ApiResource;

class Webhook extends ApiResource
{

    /**
     * Create an Order
     *
     * @param array $params
     * @return array
     */
    public function resend(string $id, array $params = []): array
    {
        return $this->getApiRequestor()->postRequest('/api/webhook/resend/'.$id, $params);
    }

}