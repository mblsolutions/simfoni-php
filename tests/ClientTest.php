<?php

namespace MBLSolutions\Simfoni\Tests;

use MBLSolutions\Simfoni\Client;
use MBLSolutions\Simfoni\Simfoni;

class ClientTest extends TestCase
{
    /** @var Client $client */
    protected $client;

    /** {@inheritdoc} **/
    public function setUp()
    {
        parent::setUp();

        Simfoni::setToken('test-token');

        $this->client = new Client();
    }

    /** @test * */
    public function can_list_all_clients(): void
    {
        $this->mockExpectedHttpResponse([
            'data' => [
                [
                    'urn' => '11112222',
                    'name' => 'Foo Corp',
                ],
                [
                    'urn' => '33334444',
                    'name' => 'Bar Corp',
                ],
            ]
        ]);

        self::assertEquals($this->client->all(), $this->getMockedResponseBody());
    }

    /** @test * */
    public function can_show_client(): void
    {
        $this->mockExpectedHttpResponse([
            'data' => [
                [
                    'urn' => '11112222',
                    'name' => 'Foo Corp',
                ],
            ]
        ]);

        self::assertEquals($this->client->show('11112222'), $this->getMockedResponseBody());
    }

}