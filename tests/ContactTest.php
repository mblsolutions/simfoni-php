<?php

namespace MBLSolutions\Simfoni\Tests;

use MBLSolutions\Simfoni\Contact;
use MBLSolutions\Simfoni\Simfoni;

class ContactTest extends TestCase
{
    /** @var Contact $contact */
    protected $contact;

    /** {@inheritdoc} **/
    public function setUp()
    {
        parent::setUp();

        Simfoni::setToken('test-token');

        $this->contact = new Contact();
    }

    /** @test * */
    public function can_list_all_contacts(): void
    {
        $this->mockExpectedHttpResponse([
            'data' => [
                [
                    'id' => 1,
                    'title' => 'Mr',
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                ],
                [
                    'id' => 2,
                    'title' => 'Miss',
                    'first_name' => 'Jane',
                    'last_name' => 'Doe',
                ],
            ]
        ]);

        self::assertEquals($this->contact->all(), $this->getMockedResponseBody());
    }

    /** @test * */
    public function can_show_contact(): void
    {
        $this->mockExpectedHttpResponse([
            'data' => [
                [
                    'id' => 1,
                    'title' => 'Mr',
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                ],
            ]
        ]);

        self::assertEquals($this->contact->show(1), $this->getMockedResponseBody());
    }

    /** @test * */
    public function can_search_for_contact(): void
    {
        $this->mockExpectedHttpResponse([
            'data' => [
                [
                    'id' => 1,
                    'title' => 'Mr',
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                ],
            ]
        ]);

        self::assertEquals($this->contact->search([
            'first_name' => 'john'
        ]), $this->getMockedResponseBody());
    }

}