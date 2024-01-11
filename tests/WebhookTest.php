<?php

namespace MBLSolutions\Simfoni\Tests;

use MBLSolutions\Simfoni\Order;
use MBLSolutions\Simfoni\Simfoni;
use MBLSolutions\Simfoni\Webhook;

class WebhookTest extends TestCase
{
    /** @var Order $order */
    protected $order;

    /** {@inheritdoc} **/
    public function setUp(): void
    {
        parent::setUp();

        Simfoni::setToken('test-token');

        $this->webhook = new Webhook();
    }

    /** @test * */
    public function can_request_webhook_resend()
    {
        $id = 'test-1111';
        $params = ['event' => 'order.cancelled', 'type' => 'reference'];

        $this->mockExpectedHttpResponse([
            'message' => 'Webhook order.cancelled for order 123 resent'
        ]);

        self::assertEquals($this->webhook->resend($id, $params), $this->getMockedResponseBody());
    }

    /** @test * */
    public function can_request_webhook_resend_with_defaults()
    {
        $id = '123';

        $this->mockExpectedHttpResponse([
            'message' => 'Webhook order.complete for order 123 resent'
        ]);

        self::assertEquals($this->webhook->resend($id), $this->getMockedResponseBody());
    }

    /** @test * */
    public function can_not_request_webhook_without_id()
    {
        self::expectException('ArgumentCountError');
        $this->webhook->resend();
    }
}