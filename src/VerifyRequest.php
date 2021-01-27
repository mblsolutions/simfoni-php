<?php

namespace MBLSolutions\Simfoni;

class VerifyRequest
{

    /** @var string */
    protected $webhookSignature;

    /** @var string */
    protected $headerSignature;

    /**
     * Simfoni Request Verification
     *
     * @param  string  $webhookSignature
     * @param  string  $headerSignature
     */
    public function __construct(string $webhookSignature, string $headerSignature)
    {
        $this->webhookSignature = $webhookSignature;
        $this->headerSignature = $headerSignature;
    }

    /**
     * Validate Request
     *
     * @param  array  $request
     * @return mixed
     */
    public function validates(array $request): bool
    {
        $signature = explode(',', $this->headerSignature);
        $time = $signature[0] ?? null;

        $requestHash = hash('SHA256', $this->webhookSignature.$time.json_encode($request));

        return in_array($requestHash, $signature, true);
    }

}