<?php

class ClientTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->guzzleClient = new \GuzzleHttp\Client();
    }

    /**
     * @dataProvider dataProvider
     */
    public function testVerify($mockResponseFile, $expects)
    {
        $mock = (new GuzzleHttp\Subscriber\Mock())->addResponse(__DIR__. $mockResponseFile);
        $this->guzzleClient->getEmitter()->attach($mock);
        $this->client = new \REINetwork\BriteVerify\Client('1111-2222-3333-4444', $this->guzzleClient);
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
