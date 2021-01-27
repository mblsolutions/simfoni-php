<?php

namespace MBLSolutions\Simfoni;

use Exception;
use MBLSolutions\Simfoni\Api\OAuthResource;
use MBLSolutions\Simfoni\Exceptions\AuthenticationException;

class Authentication extends OAuthResource
{

    /**
     * Authenticate with the Simfoni API using Password Grant
     *
     * @param int $client
     * @param string $secret
     * @param string $username
     * @param string $password
     * @return array
     * @throws AuthenticationException
     */
    public function password(int $client, string $secret, string $username, string $password): array
    {
        try {
            $response = $this->getApiRequestor()->postRequest('/oauth/token', [
                'grant_type' => 'password',
                'client_id' => $client,
                'client_secret' => $secret,
                'username' => $username,
                'password' => $password,
                'scope' => '',
            ], $this->getApiRequestor()->defaultHeaders());

            Simfoni::setToken($response['access_token']);

            return $response;
        } catch (Exception $exception) {
            throw new AuthenticationException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }
    }

}