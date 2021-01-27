<?php

namespace MBLSolutions\Simfoni;

use MBLSolutions\Simfoni\Exceptions\MissingTokenException;

class Simfoni
{

    /** @var string $baseUri */
    private static $baseUri = 'https://simfoni.co.uk';

    /** @var string $token */
    private static $token;

    /** @var bool $verify */
    private static $verifySSL = true;

    /** @var string $webhookSignature */
    private static $webhookSignature;

    /** @var string */
    public const AGENT = 'Simfoni-PHP';
    public const VERSION = '1.0.0';

    /**
     * Override the default baseUri
     *
     * @param  string|null  $baseUri
     * @return void
     */
    public static function setBaseUri(string $baseUri = null): void
    {
        if ($baseUri) {
            self::$baseUri = $baseUri;
        }
    }

    /**
     * Get the Inspired Deck Base URI
     *
     * @return string
     */
    public static function getBaseUri(): string
    {
        return self::$baseUri;
    }

    /**
     * Set the Bearer Token
     *
     * @param  string  $token
     * @return void
     */
    public static function setToken(string $token)
    {
        self::$token = $token;
    }

    /**
     * Get the Bearer Token
     *
     * @return string
     * @throws MissingTokenException
     */
    public static function getToken(): string
    {
        $token = self::$token;

        if ($token === null) {
            throw new MissingTokenException('Missing Bearer Token in Simfoni Configuration');
        }

        return $token;
    }

    /**
     * Set VerifyRequest SSL
     *
     * @param  bool  $verify
     * @return void
     */
    public static function setVerifySSL(bool $verify): void
    {
        self::$verifySSL = $verify;
    }

    /**
     * Get VerifyRequest SSL
     *
     * @return bool
     */
    public static function getVerifySSL(): bool
    {
        return self::$verifySSL;
    }

    /**
     * Set Webhook Signature
     *
     * @param  string  $webhookSignature
     * @return void
     */
    public static function setWebhookSignature(string $webhookSignature): void
    {
        self::$webhookSignature = $webhookSignature;
    }

    /**
     * Get Webhook Signature
     *
     * @return string|null
     */
    public static function getWebhookSignature(): ?string
    {
        return self::$webhookSignature;
    }

}