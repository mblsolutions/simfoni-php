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

        if ($expected === $this->headerSignature) {
            return true;
        }

        return $this->validateLegacy($request);
    }

    /**
     * Validate Legacy Request (with time component)
     *
     * @param array $request
     * @return bool
     */
    private function validateLegacy(array $request): bool
    {
        $signature = explode(',', $this->headerSignature);
        $time = $signature[0] ?? null;

        if ($time === null || count($signature) < 2) {
            return false;
        }

        $expected = hash('SHA256', $this->webhookSignature.$time.json_encode($request));

        return in_array($expected, $signature, true);
    }


    public function computeExpectedHash(array $request): string
    {
        return hash('SHA256', $this->webhookSignature.json_encode($request));
    }

}
