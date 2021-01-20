<?php

namespace MBLSolutions\Simfoni;

class Decrypter
{

    /** @var string */
    private $base64Key;

    /** @var string */
    private $encryptedString;

    /** @var string */
    private $method;

    /**
     * Decrypter constructor.
     * @param  string  $base64Key
     * @param  string  $encryptedString
     * @param  string  $method
     */
    public function __construct(string $base64Key, string $encryptedString, $method = 'AES-256-CBC')
    {
        $this->base64Key = $base64Key;
        $this->encryptedString = $encryptedString;
        $this->method = $method;
    }

    /**
     * Perform the decryption
     *
     * @return false|string
     */
    public function decrypt()
    {
        $key = base64_decode($this->base64Key);
        $encryptObject = base64_decode($this->encryptedString);

        $encryptArray = json_decode($encryptObject, false);
        $iv = base64_decode($encryptArray->iv);
        $encryptObjectValue = $encryptArray->value;

        return openssl_decrypt($encryptObjectValue, $this->method, $key, 0, $iv);
    }

}