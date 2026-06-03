<?php

namespace MBLSolutions\Simfoni\Tests;

use MBLSolutions\Simfoni\VerifyRequest;

class VerifyRequestTest extends TestCase
{

    /** @test **/
    public function can_verify_request_signature(): void
    {
        $time = 1656066775;
        $json = '{"event":"order.complete","created":'.$time.',"live":true,"version":"v4.12.15","data":{"order_id":7290109,"hash":"eyJpdiI6ImJSMGgwMHI3cEZcL00xS0hwTk5WaHdnPT0iLCJ2YWx1ZSI6IkFmaUNZdHdET1JRbFdiYzQ1b2o5UGc9PSIsIm1hYyI6ImUzYjFkODMxZTZlZTYwOTE3ZGIyZjUwYTk2NjEwMzg0MmM5ZGY4YTljZDExMjhhZDNiOWE2NGIwNWZiNjlkMjkifQ=="}}';
        $request = json_decode($json, true);
        $simfoniSignature = $this->computeExpectedHash($request, 'Yih7Ry8MkNaFPfzv6S4ZMCMC59FWMfQl', $time);

        $validator = new VerifyRequest('Yih7Ry8MkNaFPfzv6S4ZMCMC59FWMfQl', $simfoniSignature);

        $this->assertTrue($validator->validates($request));
    }

    /** @test **/
    public function simfoni_compute_expected_hash(): void
    {
        $time = 1656066775;
        $json = '{"event":"order.complete","created":'.$time.',"live":true,"version":"v4.12.15","data":{"order_id":7290109,"hash":"eyJpdiI6ImJSMGgwMHI3cEZcL00xS0hwTk5WaHdnPT0iLCJ2YWx1ZSI6IkFmaUNZdHdET1JRbFdiYzQ1b2o5UGc9PSIsIm1hYyI6ImUzYjFkODMxZTZlZTYwOTE3ZGIyZjUwYTk2NjEwMzg0MmM5ZGY4YTljZDExMjhhZDNiOWE2NGIwNWZiNjlkMjkifQ=="}}';
        $request = json_decode($json, true);

        $validator = new VerifyRequest(
            'Yih7Ry8MkNaFPfzv6S4ZMCMC59FWMfQl',
            $this->computeExpectedHash($request, 'Yih7Ry8MkNaFPfzv6S4ZMCMC59FWMfQl', $time)
        );

        $this->assertEquals(
            $time.',a477f82d3cef19b4fd82096a109d2fe20265e3e2bead0e4128a9fec2bbedb664',
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

    private function computeExpectedHash($request, $signature, $time): string
    {
        return $time.','.hash('SHA256', $signature.$time.json_encode($request));
    }

}