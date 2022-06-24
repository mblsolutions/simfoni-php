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
     * @param string $excepted
     * @return mixed
     */
    public function validates(array $request, string $excepted): bool
    {
       $hash = $this->computeExpectedHash($request);

        return $hash === $excepted;
    }


    public function computeExpectedHash(array $request): string
    {
        $signature = explode(',', $this->headerSignature);
        $time = $signature[0] ?? null;

        return hash('SHA256', $this->webhookSignature.$time.json_encode($request));
    }

}