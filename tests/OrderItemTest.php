<?php

namespace MBLSolutions\Simfoni\Tests;

use MBLSolutions\Simfoni\Contact;
use MBLSolutions\Simfoni\OrderItem;
use MBLSolutions\Simfoni\Product;
use MBLSolutions\Simfoni\Simfoni;

class OrderItemTest extends TestCase
{
    /** @var OrderItem $orderItem */
    protected $orderItem;

    /** {@inheritdoc} **/
    public function setUp()
    {
        parent::setUp();

        Simfoni::setToken('test-token');

        $this->orderItem = new OrderItem();
    }

    /** @test * */
    public function can_show_items_for_order(): void
    {
        $this->mockExpectedHttpResponse([
            'data' => [
                [
                    'id' => 1,
                    'product' => [
                        'id' => 1,
                        'sku' => '2239199669790',
                        'name' => 'Product',
                    ],
                    'quantity' => 1,
                ],
            ]
        ]);

        self::assertEquals($this->orderItem->show(1), $this->getMockedResponseBody());
    }

}