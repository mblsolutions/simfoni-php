<?php

namespace MBLSolutions\Simfoni\Tests;

use MBLSolutions\Simfoni\VerifyRequest;

class VerifyRequestTest extends TestCase
{

    /** @test **/
    public function can_verify_request_signature(): void
    {
        $json = '{"event":"order.complete","created":1656066775,"live":true,"version":"v4.12.15","data":{"order_id":7290109,"hash":"eyJpdiI6ImJSMGgwMHI3cEZcL00xS0hwTk5WaHdnPT0iLCJ2YWx1ZSI6IkFmaUNZdHdET1JRbFdiYzQ1b2o5UGc9PSIsIm1hYyI6ImUzYjFkODMxZTZlZTYwOTE3ZGIyZjUwYTk2NjEwMzg0MmM5ZGY4YTljZDExMjhhZDNiOWE2NGIwNWZiNjlkMjkifQ=="}}';
        $request = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $validator = new VerifyRequest('Yih7Ry8MkNaFPfzv6S4ZMCMC59FWMfQl', '1656066775,bb23e6712079908c80e1e3c9e88876db59a3c0750bc6e0d4a0be69be5de4c17d');

        $this->assertTrue($validator->validates($request, 'a477f82d3cef19b4fd82096a109d2fe20265e3e2bead0e4128a9fec2bbedb664'));
    }

    /** @test */
    public function simfoni_signature_test(): void
    {
        $json = '{"event":"order.complete","created":1656066775,"live":true,"version":"v4.12.15","data":{"order_id":7290109,"hash":"eyJpdiI6ImJSMGgwMHI3cEZcL00xS0hwTk5WaHdnPT0iLCJ2YWx1ZSI6IkFmaUNZdHdET1JRbFdiYzQ1b2o5UGc9PSIsIm1hYyI6ImUzYjFkODMxZTZlZTYwOTE3ZGIyZjUwYTk2NjEwMzg0MmM5ZGY4YTljZDExMjhhZDNiOWE2NGIwNWZiNjlkMjkifQ=="}}';
        $request = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $sig = 'Yih7Ry8MkNaFPfzv6S4ZMCMC59FWMfQl';
        $signature = explode(',', '1656066775,bb23e6712079908c80e1e3c9e88876db59a3c0750bc6e0d4a0be69be5de4c17d');

        $hash = hash('SHA256', $sig . $signature[0] . json_encode($request, JSON_THROW_ON_ERROR));

        $this->assertEquals('a477f82d3cef19b4fd82096a109d2fe20265e3e2bead0e4128a9fec2bbedb664', $hash);
    }

    /** @test **/
    public function simfoni_compute_expected_hash(): void
    {
        $json = '{"event":"order.complete","created":1656066775,"live":true,"version":"v4.12.15","data":{"order_id":7290109,"hash":"eyJpdiI6ImJSMGgwMHI3cEZcL00xS0hwTk5WaHdnPT0iLCJ2YWx1ZSI6IkFmaUNZdHdET1JRbFdiYzQ1b2o5UGc9PSIsIm1hYyI6ImUzYjFkODMxZTZlZTYwOTE3ZGIyZjUwYTk2NjEwMzg0MmM5ZGY4YTljZDExMjhhZDNiOWE2NGIwNWZiNjlkMjkifQ=="}}';
        $request = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $validator = new VerifyRequest(
            'Yih7Ry8MkNaFPfzv6S4ZMCMC59FWMfQl',
            '1656066775,bb23e6712079908c80e1e3c9e88876db59a3c0750bc6e0d4a0be69be5de4c17d'
        );

        $this->assertEquals(
            'a477f82d3cef19b4fd82096a109d2fe20265e3e2bead0e4128a9fec2bbedb664',
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

}