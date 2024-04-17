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
     * @param array $request
     * @return mixed
     */
    public function validates(array $request): bool
    {
        $expected = $this->computeExpectedHash($request);

        return $expected === $this->headerSignature;
    }


    public function computeExpectedHash(array $request): string
    {
        return hash('SHA256', $this->webhookSignature.json_encode($request));
    }

}
