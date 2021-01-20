<?php

namespace MBLSolutions\Simfoni\Tests;

use MBLSolutions\Simfoni\Account;
use MBLSolutions\Simfoni\Simfoni;

class AccountTest extends TestCase
{
    /** @var Account $account */
    protected $account;

    /** {@inheritdoc} **/
    public function setUp()
    {
        parent::setUp();

        Simfoni::setToken('test-token');

        $this->account = new Account();
    }

    /** @test * */
    public function can_show_account(): void
    {
        $this->mockExpectedHttpResponse([
            'data' => [
                [
                    'id' => 6000000,
                ],
            ]
        ]);

        self::assertEquals($this->account->show(), $this->getMockedResponseBody());
    }

}