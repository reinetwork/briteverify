<?php

use PHPUnit\Framework\TestCase;
use REINetwork\BriteVerify\Client;

class ClientIntegrationTest extends TestCase
{
    /** @var string */
    private $token;

    /** @var  Client */
    private $client;

    public function setUp()
    {
        $this->token = "";  // Insert the token here for testing
        $this->client = new Client($this->token);
    }

    /**
     * Validates that the verify function works with actual data. Fill in the fields as needed to actually test
     * the function out. Otherwise, if the token is empty, then the test will pass by default but not run anything.
     *
     * @dataProvider dataProvider
     *
     * @param string $email
     * @param string $expected
     */
    public function testVerifyWorks($email, $expected)
    {
        // If token is set, proceed with test. Otherwise, ignore this test
        if (!empty($this->token)) {
            $results = $this->client->verify($email);
            $this->assertEquals($expected, $results->status);
        }
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        return [
            ['kenneth@reinetworklp.com', "valid"],
            ['kenneth@asdfasdf.com', "invalid"],
        ];
    }
}
