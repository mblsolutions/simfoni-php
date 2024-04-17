<?php

namespace MBLSolutions\Simfoni\Tests;

use MBLSolutions\Simfoni\VerifyRequest;

class VerifyRequestTest extends TestCase
{

    /** @test **/
    public function can_verify_request_signature(): void
    {
        $json = '{"event":"order.complete","created":1656066775,"live":true,"version":"v4.12.15","data":{"order_id":7290109,"hash":"eyJpdiI6ImJSMGgwMHI3cEZcL00xS0hwTk5WaHdnPT0iLCJ2YWx1ZSI6IkFmaUNZdHdET1JRbFdiYzQ1b2o5UGc9PSIsIm1hYyI6ImUzYjFkODMxZTZlZTYwOTE3ZGIyZjUwYTk2NjEwMzg0MmM5ZGY4YTljZDExMjhhZDNiOWE2NGIwNWZiNjlkMjkifQ=="}}';
        $request = json_decode($json, true);
        $simfoniSignature = $this->computeExpectedHash($request, 'Yih7Ry8MkNaFPfzv6S4ZMCMC59FWMfQl');

        $validator = new VerifyRequest('Yih7Ry8MkNaFPfzv6S4ZMCMC59FWMfQl', $simfoniSignature);

        $this->assertTrue($validator->validates($request));
    }

    /** @test **/
    public function simfoni_compute_expected_hash(): void
    {
        $json = '{"event":"order.complete","created":1656066775,"live":true,"version":"v4.12.15","data":{"order_id":7290109,"hash":"eyJpdiI6ImJSMGgwMHI3cEZcL00xS0hwTk5WaHdnPT0iLCJ2YWx1ZSI6IkFmaUNZdHdET1JRbFdiYzQ1b2o5UGc9PSIsIm1hYyI6ImUzYjFkODMxZTZlZTYwOTE3ZGIyZjUwYTk2NjEwMzg0MmM5ZGY4YTljZDExMjhhZDNiOWE2NGIwNWZiNjlkMjkifQ=="}}';
        $request = json_decode($json, true);

        $validator = new VerifyRequest(
            'Yih7Ry8MkNaFPfzv6S4ZMCMC59FWMfQl',
            $this->computeExpectedHash($request, 'Yih7Ry8MkNaFPfzv6S4ZMCMC59FWMfQl')
        );

        $this->assertEquals(
            '4d6db9405ea37e2f45196f957bf5ffaab409be58ff8a29f51435070f4c89c20f',
            $validator->computeExpectedHash($request)
        );
    }

    /** @test */
    public function invalid_requests_return_as_invalid(): void
    {
        $verifyRequest = new VerifyRequest('webhook-signature', 'fake-header-signature');
        self::assertFalse($verifyRequest->validates([
            'data' => 'sample'
        ], 'this-is-not-valid'));
    }

    private function computeExpectedHash($request, $signature): string
    {
        return hash('SHA256', $signature.json_encode($request));
    }

}