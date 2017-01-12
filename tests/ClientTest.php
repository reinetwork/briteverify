<?php

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use REINetwork\BriteVerify\Client;

class ClientTest extends PHPUnit_Framework_TestCase
{
    protected $guzzleClient;
    protected $client;

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @param $mockResponseFile
     * @param $expects
     *
     * @dataProvider dataProvider
     */
    public function testVerify($mockResponseFile, $expects)
    {
        $mock = new MockHandler([
            $response = new Response(
                200,
                [],
                \GuzzleHttp\Psr7\stream_for(fopen(__DIR__.$mockResponseFile, 'r'))
            )
        ]);

        $handler = \GuzzleHttp\HandlerStack::create($mock);
        $this->guzzleClient = new \GuzzleHttp\Client(['handler' => $handler ]);
        $this->client = new Client('1111-2222-3333-4444', $this->guzzleClient);
        $response = $this->client->verify('johndoe@briteverify.com');

        $this->assertSame($expects['isValid'], $response->isValid());
        $this->assertSame($expects['isInvalid'], $response->isInvalid());
        $this->assertSame($expects['isAcceptAll'], $response->isAcceptAll());
        $this->assertSame($expects['isUnknown'], $response->isUnknown());
    }

    public function dataProvider()
    {
        return [
            [
                '/mock/http_response_invalid.txt',
                [
                    'isValid' => false,
                    'isInvalid' => true,
                    'isAcceptAll' => false,
                    'isUnknown' => false,
                ]
            ],
            [
                '/mock/http_response_valid.txt',
                [
                    'isValid' => true,
                    'isInvalid' => false,
                    'isAcceptAll' => false,
                    'isUnknown' => false,
                ]
            ],
            [
            '/mock/http_response_null_email.txt',
                [
                    'isValid' => false,
                    'isInvalid' => true,
                    'isAcceptAll' => false,
                    'isUnknown' => false,
                ]
            ]
        ];
    }
}
