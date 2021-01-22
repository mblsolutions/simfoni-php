<?php

namespace MBLSolutions\Simfoni\Tests;

use MBLSolutions\Simfoni\IssuedInfo;
use MBLSolutions\Simfoni\Simfoni;

class IssuedInfoTest extends TestCase
{
    /** @var IssuedInfo $issuedInfo */
    protected $issuedInfo;

    /** {@inheritdoc} **/
    public function setUp()
    {
        parent::setUp();

        Simfoni::setToken('test-token');

        $this->issuedInfo = new IssuedInfo();
    }

    /** @test * */
    public function can_show_issued_info(): void
    {
        $this->mockExpectedHttpResponse([
            'data' => [
                [
                    'item_id' => 'abc123',
                    'sku' => '2239199669790',
                    'masked_pan' => '************1350',
                    'masked_serial' => '****4360',
                ],
            ]
        ]);

        self::assertEquals($this->issuedInfo->show('hash-here'), $this->getMockedResponseBody());
    }

}