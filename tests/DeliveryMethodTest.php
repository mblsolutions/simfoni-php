<?php

namespace MBLSolutions\Simfoni\Tests;

use MBLSolutions\Simfoni\Contact;
use MBLSolutions\Simfoni\DeliveryMethod;
use MBLSolutions\Simfoni\Simfoni;

class DeliveryMethodTest extends TestCase
{
    /** @var Contact $contact */
    protected $deliveryMethod;

    /** {@inheritdoc} **/
    public function setUp()
    {
        parent::setUp();

        Simfoni::setToken('test-token');

        $this->deliveryMethod = new DeliveryMethod();
    }

    /** @test * */
    public function can_list_all_delivery_methods(): void
    {
        $this->mockExpectedHttpResponse([
            'data' => [
                [
                    'id' => 1,
                    'name' => 'Royal Mail',
                ],
                [
                    'id' => 2,
                    'name' => 'Fedex',
                ],
            ]
        ]);

        self::assertEquals($this->deliveryMethod->all(), $this->getMockedResponseBody());
    }

    /** @test * */
    public function can_show_delivery_method(): void
    {
        $this->mockExpectedHttpResponse([
            'data' => [
                [
                    'id' => 1,
                    'name' => 'Royal Mail',
                ],
            ]
        ]);

        self::assertEquals($this->deliveryMethod->show(1), $this->getMockedResponseBody());
    }

}