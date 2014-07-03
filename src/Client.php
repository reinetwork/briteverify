<?php

namespace REINetwork\BriteVerify;

use SebastianBergmann\Exporter\Exception;

class Client
{
    protected $token = null;

    protected $client = null;

    protected $endpoint = 'https://bpi.briteverify.com/emails.json';

    public function __construct($token, \GuzzleHttp\Client $client = null)
    {
        $this->token = $token;
        $this->client = $client ?: new \GuzzleHttp\Client();
    }

    public function getRequest($token, $address)
    {
        // configure the request object
        $options = [
            'exceptions' => false,
            'verify' => false,

        ];

        // create request object and set query string variables
        $request = $this->client->createRequest('GET', $this->endpoint, $options);
        $request->getQuery()->set('apikey', $token);
        $request->getQuery()->set('address', $address);

        return $request;
    }

    public function getResponse(\GuzzleHttp\Message\Response $response)
    {
        if ($response->getStatusCode() !== '200') {
            throw new \Exception('request failed');
        }

        return new Response($response);
    }

    public function verify($address)
    {
        $request = $this->getRequest($this->token, $address);

        $response = $this->client->send($request);

        return $this->getResponse($response);
    }
}