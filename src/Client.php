<?php

namespace REINetwork\BriteVerify;

/**
 * A client wrapper to call BriteVerify /emails API.
 */
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

    /**
     * Creates the request GET object to call the API.
     * @param  String $token   The API user token.
     * @param  String $address The email to validate.
     * @return GuzzleHttp\Message\Request
     */
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

    /**
     * Maps the Guzzle's response into a Response object.
     * @param  \GuzzleHttp\Message\Response $response The response object.
     * @return Response
     */
    public function getResponse(\GuzzleHttp\Message\Response $response)
    {
        if ($response->getStatusCode() !== '200') {
            throw new \Exception('request failed');
        }

        return new Response($response);
    }

    /**
     * Calls the API to verify if a given email address is valid.
     * @param  String $address The email to validate.
     * @return Response
     */
    public function verify($address)
    {
        $request = $this->getRequest($this->token, $address);

        $response = $this->client->send($request);

        return $this->getResponse($response);
    }
}
