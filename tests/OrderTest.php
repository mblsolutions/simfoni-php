<?php

namespace MBLSolutions\Simfoni\Tests;

use MBLSolutions\Simfoni\Contact;
use MBLSolutions\Simfoni\Decrypter;
use MBLSolutions\Simfoni\Order;
use MBLSolutions\Simfoni\OrderItem;
use MBLSolutions\Simfoni\Product;
use MBLSolutions\Simfoni\Simfoni;

class OrderTest extends TestCase
{
    /** @var Order $order */
    protected $order;

    /** {@inheritdoc} **/
    public function setUp()
    {
        parent::setUp();

        Simfoni::setToken('test-token');

        $this->order = new Order();
    }

    /** @test * */
    public function can_create_order(): void
    {
        $this->mockExpectedHttpResponse([
            'urn' => 1234,
            'order_ref' => 'ORD-000001',
        ]);

        self::assertEquals($this->order->create([
            'urn' => 1234,
            'items' => [
                'data' => [
                    [
                        'sku' => 'EXAMPLE_SKU',
                        'quantity' => 1,
                        'price' => 10.00,
                        'activation_date' => '2021-01-01T17:00:00+00:00',
                    ],
                ]
            ]
        ]), $this->getMockedResponseBody());
    }

    /** @test * */
    public function can_cancel_order(): void
    {
        $this->mockExpectedHttpResponse([
            'message' => 'Order #1 cancelled.'
        ]);

        self::assertEquals($this->order->cancel(1), $this->getMockedResponseBody());
    }

    /** @test * */
    public function can_search_orders(): void
    {
        $this->mockExpectedHttpResponse([
            'data' => [
                [
                    'id' => 1,
                    'reference' => 'ref-1111',
                ],
            ]
        ]);

        self::assertEquals($this->order->search([
            'reference' => 'ref-1111',
        ]), $this->getMockedResponseBody());
    }

    /** @test * */
    public function can_show_order(): void
    {
        $this->mockExpectedHttpResponse([
            'data' => [
                [
                    'id' => 1,
                    'reference' => 'ref-1111',
                ],
            ]
        ]);

        self::assertEquals($this->order->show(1), $this->getMockedResponseBody());
    }

    /** @test * */
    public function can_list_all_orders(): void
    {
        $this->mockExpectedHttpResponse([
            'data' => [
                [
                    'id' => 1,
                    'reference' => 'ref-1111',
                ],
                [
                    'id' => 2,
                    'reference' => 'ref-2222',
                ],
            ]
        ]);

        self::assertEquals($this->order->all(), $this->getMockedResponseBody());
    }

    /** @test * */
    public function can_list_all_orders_between_dates(): void
    {
        $this->mockExpectedHttpResponse([
            'data' => [
                [
                    'id' => 1,
                    'reference' => 'ref-1111',
                ],
                [
                    'id' => 2,
                    'reference' => 'ref-2222',
                ],
            ]
        ]);

        self::assertEquals($this->order->all([
            'start_date' => '2021-01-01T00:00:00+0000',
            'end_date' => '2021-12-01T00:00:00+0000',
        ]), $this->getMockedResponseBody());
    }

    /** @test */
    public function can_decrypt_order_information(): void
    {
        $base64Key = 'b1Nr/nNInIcZqb2AfNA6HHQi50K0pFi+5+5F0gm/s1E=';
        $encryptedString = 'eyJpdiI6InFiV0d1YnRCNmZYeGhkSGJSNlA4eHc9PSIsInZhbHVlIjoicUFDejBQWWEwa29jbno5b3ZyN0Ywdz09IiwibWFjIjoiNWM1ZjdjM2MxNTliNGNkNDcyMmUxMWI2NDhjYmNiOTc0ZTUzNmZlOGI2ZjVlZjNkY2I0ZTgwZTcyM2EzOTA5NSJ9';

        self::assertEquals('test', unserialize($this->order->decrypt($base64Key, $encryptedString)));
    }

    /** @test */
    public function can_decrypt_order_information_alternative(): void
    {
        $base64Key = 'b1Nr/nNInIcZqb2AfNA6HHQi50K0pFi+5+5F0gm/s1E=';
        $encryptedString = 'eyJpdiI6InFiV0d1YnRCNmZYeGhkSGJSNlA4eHc9PSIsInZhbHVlIjoicUFDejBQWWEwa29jbno5b3ZyN0Ywdz09IiwibWFjIjoiNWM1ZjdjM2MxNTliNGNkNDcyMmUxMWI2NDhjYmNiOTc0ZTUzNmZlOGI2ZjVlZjNkY2I0ZTgwZTcyM2EzOTA5NSJ9';

        self::assertEquals('test', unserialize((new Decrypter($base64Key, $encryptedString))->decrypt()));
    }

}