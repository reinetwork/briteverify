<?php
namespace REINetwork\BriteVerify;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

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
     * @var GuzzleClient Guzzle client
     */
    protected $client;

    /**
     * @var string BriteVerify API URL
     */
    protected $endpoint = 'https://bpi.briteverify.com/emails.json';

    /**
     * Constructor -- handle dependency injection.
     *
     * @param $token
     * @param GuzzleClient $client
     */
    public function __construct($token, GuzzleClient $client = null)
    {
        $this->token = $token;
        $this->client = $client ? : new GuzzleClient();
    }

    /**
     * Maps the Guzzle's response into a Response object.
     *
     * @param  Request $request The request object.
     * @param  Response $response The response object.
     *
     * @throws BadResponseException
     *
     * @return \REINetwork\BriteVerify\Response
     */
    public function getResponse(Request $request, Response $response)
    {
        if ($response->getStatusCode() !== 200) {
            throw new BadResponseException('request failed', $request, $response);
        }

        return new \REINetwork\BriteVerify\Response($response);
    }

    /**
     * Calls the API to verify if a given email address is valid.
     *
     * @param  String $address The email to validate.
     * @return \REINetwork\BriteVerify\Response
     */
    public function verify($address)
    {
        $request = new Request(
            'GET',
            $this->endpoint,
            [
                'apikey' => $this->token,
                'address' => $address,
            ]
        );

        $response = $this->client->send($request);

        return $this->getResponse($request, $response);
    }
}
