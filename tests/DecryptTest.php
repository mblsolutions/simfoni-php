<?php

namespace MBLSolutions\Simfoni\Tests;

use MBLSolutions\Simfoni\Decrypt;
use MBLSolutions\Simfoni\Exceptions\DecryptionException;

class DecryptTest extends TestCase
{

    /** @test **/
    public function can_decrypt_pan_data(): void
    {
        $decrypt = new Decrypt('JD62JFgGrKJdc1UsZmHykg==', 'AES-128-CBC');

        $string = 'eyJpdiI6Ikhjdlp1Uzc0WFZ2MkdDZ3lHc3VVQnc9PSIsInZhbHVlIjoiXC8reHhBditLWUc3eDdiWlFhVm96enBXQlhJSUR6VzZZb3I4NE9MNkd6Tms9IiwibWFjIjoiYjFiNWRlYzI0NDY2ZmZmYTk4NGJhMjgxN2EwZTAyZjg0YzJmNjg5YmNiMDA2ZDQ1OWViODgxM2QwM2FiNjk3YSJ9';

        $result = $decrypt->data($string);

        self::assertEquals(2000101764339760, $result);
    }


    /** @test **/
    public function can_decrypt_pin_data(): void
    {
        $decrypt = new Decrypt('JD62JFgGrKJdc1UsZmHykg==', 'AES-128-CBC');

        $string = 'eyJpdiI6IlhWNDJuUnF0dnBSdjVsM0J3c2RwTkE9PSIsInZhbHVlIjoiTnU3bDRCT000amJudldFTTB6MVFPUT09IiwibWFjIjoiNzhhMzg3ZmMxZDNkMGE5ODA1N2Q3MWFkYmVkY2NmY2I4YTk5NWMxYTk3YTNjZGFiZTU5OTA1ZGI5OWJjZDA2YyJ9';

        $result = $decrypt->data($string);

        self::assertEquals(3840, $result);
    }

    /** @test **/
    public function invalid_key_throws_exception(): void
    {
        $this->expectException(DecryptionException::class);

        $decrypt = new Decrypt('bm90X2FfdmFsaWRfa2V5', 'AES-128-CBC');

        $string = 'eyJpdiI6IlhWNDJuUnF0dnBSdjVsM0J3c2RwTkE9PSIsInZhbHVlIjoiTnU3bDRCT000amJudldFTTB6MVFPUT09IiwibWFjIjoiNzhhMzg3ZmMxZDNkMGE5ODA1N2Q3MWFkYmVkY2NmY2I4YTk5NWMxYTk3YTNjZGFiZTU5OTA1ZGI5OWJjZDA2YyJ9';

        $decrypt->data($string);
    }

    /** @test **/
    public function supplying_a_key_that_is_not_base_64_encoded_throws_exception(): void
    {
        $this->expectException(DecryptionException::class);

        $decrypt = new Decrypt('not_a_valid_key');

        $string = 'eyJpdiI6IlhWNDJuUnF0dnBSdjVsM0J3c2RwTkE9PSIsInZhbHVlIjoiTnU3bDRCT000amJudldFTTB6MVFPUT09IiwibWFjIjoiNzhhMzg3ZmMxZDNkMGE5ODA1N2Q3MWFkYmVkY2NmY2I4YTk5NWMxYTk3YTNjZGFiZTU5OTA1ZGI5OWJjZDA2YyJ9';

        $decrypt->data($string);
    }

    /** @test **/
    public function supplying_a_string_that_is_not_a_valid_encryption_object_encoded_throws_exception(): void
    {
        $this->expectException(DecryptionException::class);

        $decrypt = new Decrypt('JD62JFgGrKJdc1UsZmHykg==');

        $string = 'bm90X2FfdmFsaWRfa2V5';

        $decrypt->data($string);
    }

    /** @test **/
    public function supplying_a_string_that_is_not_base_64_encoded_throws_exception(): void
    {
        $this->expectException(DecryptionException::class);

        $decrypt = new Decrypt('Not a valid object');

        $string = 'bm90X2FfdmFsaWRfa2V5';

        $decrypt->data($string);
    }

}