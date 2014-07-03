<?php

require '../vendor/autoload.php';

use REINetwork\BriteVerify\Client;

// mock the HTTP request
$guzzle = new GuzzleHttp\Client();
$mock = new GuzzleHttp\Subscriber\Mock(['mock/example_response.txt']);
$guzzle->getEmitter()->attach($mock);

$client = new Client('26198378-8fd2-4af9-8a9e-9c45422c8d91', $guzzle);

$response = $client->verify('johndoe@briteverify.com');

var_dump([
    'response' => $response,
    'isValid' => $response->isValid(),
    'isInvalid' => $response->isInvalid(),
    'isAcceptAll' => $response->isAcceptAll(),
    'isUnknown' => $response->isUnknown()
]);