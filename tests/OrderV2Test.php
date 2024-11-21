<?php

namespace MBLSolutions\Simfoni\Tests;

use MBLSolutions\Simfoni\Order;
use MBLSolutions\Simfoni\OrderV2;
use MBLSolutions\Simfoni\Simfoni;

class OrderV2Test extends OrderTest
{
    /** @var Order $order */
    protected $order;

    /** {@inheritdoc} **/
    public function setUp(): void
    {
        parent::setUp();

        $this->order = new OrderV2();
    }
}
