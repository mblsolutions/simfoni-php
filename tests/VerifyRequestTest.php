<?php

namespace MBLSolutions\Simfoni\Tests;

use MBLSolutions\Simfoni\VerifyRequest;

class VerifyRequestTest extends TestCase
{

    /** @test */
    public function can_be_instantiated_with_object(): void
    {
        self::assertInstanceOf(VerifyRequest::class, new VerifyRequest('abc', '123'));
    }

    /** @test */
    public function valid_requests_return_as_validated(): void
    {
        $time = time();
        $webhookSignature = 'webhook-signature-here';
        $payload = ['data' => 'sample'];

        // create a sample valid signature
        $headerSignature = $time.','.hash('SHA256', $webhookSignature.$time.json_encode($payload));

        $verifyRequest = new VerifyRequest($webhookSignature, $headerSignature);

        self::assertTrue($verifyRequest->validates($payload));
    }

    /** @test **/
    public function can_verify_request_signature(): void
    {
        $json = "{\"event\":\"order.complete\",\"created\":1655986287,\"live\":false,\"version\":\"v4.12.15\",\"data\":{\"order_id\":55961284,\"hash\":\"eyJpdiI6IjlLb0VLSCtINVcxYlBCeFFIV1NhZGc9PSIsInZhbHVlIjoiVGtCSE1PbllydjJLUzE5MXlrVUJ2dz09IiwibWFjIjoiZGJkYTc4N2NhZTJmNzk2NWYwNzZkY2NkYTg2MWFlNGYyYzRkMzU3ZmJiNTA3MjI5NTQ3NzQ2YTU2ZDA1MDFjYiJ9\"}}";
        $request = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $validator = new VerifyRequest('Yih7Ry8MkNaFPfzv6S4ZMCMC59FWMfQl', '1655986287,fa0b95dd83f2a783967d1cabb4a58f09716c6c87ed9f65a3c1e3f4d3061430cc');

        $this->assertTrue($validator->validates($request));
    }

    /** @test */
    public function invalid_requests_return_as_invalid(): void
    {
        $verifyRequest = new VerifyRequest('webhook-signature', 'fake-header-signature');
        self::assertFalse($verifyRequest->validates([
            'data' => 'sample'
        ]));
    }

}