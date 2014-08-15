<?php
namespace REINetwork\BriteVerify;

/**
 * A client wrapper to call BriteVerify /emails API.
 */
class Client
{
    /**
     * @var string Api Token
     */
    protected $token;

    /**
     * @var \GuzzleHttp\Client Guzzle client
     */
    protected $client;

    /**
     * @var string BriteVerify API URL
     */
    protected $endpoint = 'https://bpi.briteverify.com/emails.json';

    /**
     * @var \GuzzleHttp\Message\Request A Guzzle request
     */
    private $request;

    /**
     * Constructor -- handle dependency injection.
     *
     * @param $token
     * @param \GuzzleHttp\Client $client
     */
    public function __construct($token, \GuzzleHttp\Client $client = null)
    {
        $this->token = $token;
        $this->client = $client ?: new \GuzzleHttp\Client();
    }

    /**
     * Creates the request GET object to call the API.
     *
     * @param  String $token   The API user token.
     * @param  String $address The email to validate.
     * @return GuzzleHttp\Message\Request
     */
    public function getRequest($token, $address)
    {
        // create request object and set query string variables
        $request = $this->client->createRequest('GET', $this->endpoint);
        $request->getQuery()->set('apikey', $token);
        $request->getQuery()->set('address', $address);

        return $request;
    }

    /**
     * Maps the Guzzle's response into a Response object.
     *
     * @param  \GuzzleHttp\Message\Response $response The response object.
     * @throws \GuzzleHttp\Exception\BadResponseException
     * @return \REINetwork\BriteVerify\Response
     */
    public function getResponse(\GuzzleHttp\Message\Response $response)
    {
        if ($response->getStatusCode() !== '200') {
            throw new \GuzzleHttp\Exception\BadResponseException('request failed', $this->request, $response);
        }

        return new Response($response);
    }

    /**
     * Calls the API to verify if a given email address is valid.
     *
     * @param  String $address The email to validate.
     * @return \REINetwork\BriteVerify\Response
     */
    public function verify($address)
    {
        $this->request = $this->getRequest($this->token, $address);

        $response = $this->client->send($this->request);

        return $this->getResponse($response);
    }
}
