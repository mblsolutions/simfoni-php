<?php

namespace MBLSolutions\Simfoni\Tests;

use MBLSolutions\Simfoni\Contact;
use MBLSolutions\Simfoni\Product;
use MBLSolutions\Simfoni\Simfoni;

class ProductTest extends TestCase
{
    /** @var Product $product */
    protected $product;

    /** {@inheritdoc} **/
    public function setUp()
    {
        parent::setUp();

        Simfoni::setToken('test-token');

        $this->product = new Product();
    }

    /** @test * */
    public function can_list_all_products(): void
    {
        $this->mockExpectedHttpResponse([
            'data' => [
                [
                    'id' => 1,
                    'sku' => 'SAMPLE SKU',
                    'name' => 'Sample Product',
                ],
                [
                    'id' => 2,
                    'sku' => 'ANOTHER SKU',
                    'name' => 'Another Product',
                ],
            ]
        ]);

        self::assertEquals($this->product->all(), $this->getMockedResponseBody());
    }

    /** @test * */
    public function can_show_product(): void
    {
        $this->mockExpectedHttpResponse([
            'data' => [
                'id' => 1,
                'sku' => 'SAMPLE SKU',
                'name' => 'Sample Product',
            ]
        ]);

        self::assertEquals($this->product->show(1), $this->getMockedResponseBody());
    }

}