<?php

namespace MBLSolutions\Simfoni;

use MBLSolutions\Simfoni\Api\ApiResource;

class Contact extends ApiResource
{

    /**
     * Search Contacts
     *
     * @param  array  $params
     * @return array
     */
    public function search(array $params): array
    {
        return $this->getApiRequestor()->postRequest('/api/search/contact', $params);
    }

    /**
     * Show Contact
     *
     * @param  string  $id
     * @return array
     */
    public function show(string $id): array
    {
        return $this->getApiRequestor()->getRequest('/api/account/contact/'.$id);
    }

    /**
     * Show all Contacts
     *
     * @return array
     */
    public function all(): array
    {
        return $this->getApiRequestor()->getRequest('/api/account/contact');
    }

}