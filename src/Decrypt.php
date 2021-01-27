<?php

namespace MBLSolutions\Simfoni;

use MBLSolutions\Simfoni\Exceptions\DecryptionException;

class Decrypt
{
    /** @var string */
    protected $key;

    /** @var string */
    protected $cipher;

    /**
     * Simfoni Data Decryption
     *
     * @param string $key
     * @param string $cipher
     */
    public function __construct(string $key, string $cipher = 'AES-128-CBC')
    {
        $this->key = base64_decode($key);
        $this->cipher = $cipher;
    }

    /**
     * Decrypt Data
     *
     * @param string $data
     * @param bool $unserialize
     * @return mixed
     */
    public function data(string $data, bool $unserialize = true)
    {
        $encryptionObject = json_decode(base64_decode($data), true);

        if (!is_array($encryptionObject)) {
            throw new DecryptionException('Encrypted string is not valid decryption object');
        }

        $iv = base64_decode($encryptionObject['iv']);

        $decrypted = openssl_decrypt($encryptionObject['value'], $this->cipher, $this->key, 0, $iv);

        if ($decrypted === false) {
            throw new DecryptionException('Could not decrypt the data.');
        }

        return $unserialize ? unserialize($decrypted) : $data;
    }

}