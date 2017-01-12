<?php

use REINetwork\BriteVerify\Response;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    protected $class;

    /**
     * @param $response
     * @param $expects
     *
     * @dataProvider dataProvider
     */
    public function testClass($response, $expects)
    {
        $this->class = new Response($response);

        $this->assertSame($expects['isValid'], $this->class->isValid());
        $this->assertSame($expects['isInvalid'], $this->class->isInvalid());
        $this->assertSame($expects['isAcceptAll'], $this->class->isAcceptAll());
        $this->assertSame($expects['isUnknown'], $this->class->isUnknown());
        $this->assertSame($expects['isDisposable'], $this->class->isDisposable());
        $this->assertSame($expects['isRoleAddress'], $this->class->isRoleAddress());
        $this->assertSame($expects['getError'], $this->class->getError());
    }



    /**
     * Provides data for different scenarios
     *
     * @see  https://github.com/BriteVerify/BriteCode/blob/master/email.md
     *
     * Response Attributes
     *
     * address: the email that was passed
     * account: the inbox or account parsed from the email
     * domain: the domain parsed from the email
     * status: the status of the given email address
     * error: the error message if the email is invalid
     * error_code: a code representation of error
     * connected: whether or not a valid email is connected to active online networks
     * disposable: is the email a temporary or 'disposable' email address
     * duration: the time it took to process your request
     *
     * Status
     * There are only 4 statuses for an email in BriteVerify.
     *
     * valid: The email represents a real account / inbox available at the given domain
     * invalid: Not a real email
     * unknown: For some reason we cannot verify valid or invalid. Most of the time a domain did not respond
     *          quickly enough.
     * accept_all: These are domains that respond to every verification request in the affirmative,
     *             and therefore cannot be fully verified.
     */

    public function dataProvider()
    {
        // Unless something goes wrong, the HTTP status code will always be 200, regardless
        // if the email is valid or invalid. The above request would yield the follow response.
        $jsonValidEmail = [
            'address' => 'james@briteverify.com',
            'account' => 'james',
            'domain' => 'briteverify.com',
            'status' => 'valid',
            'connected' => true,
            'disposable' => false,
            'role_address' => false,
            'duration' => 0.0000000000,
        ];


        // If I pass an invalid email I will get not only a status of "invalid",
        // I will also get an error and and error code explaining why the email is invalid.
        $jsonInvalidEmail = [
            'address' => 'johndoe@briteverify.com',
            'account' => 'johndoe',
            'domain' => 'briteverify.com',
            'status' => 'invalid',
            'connected' => null,
            'disposable' => false,
            'role_address' => false,
            'error_code' => 'email_account_invalid',
            'error' => 'Email account invalid',
            'duration' => 0.0000000000,
        ];



        // 'status' variations
        $jsonInvalidEmailStatusAcceptAll = $jsonInvalidEmail;
        $jsonInvalidEmailStatusAcceptAll['status'] = 'accept_all';

        $jsonInvalidEmailStatusUnknown = $jsonInvalidEmail;
        $jsonInvalidEmailStatusUnknown['status'] = 'unknown';

        $validEmailResponse = $this->getGuzzleHttpResponse(200, [], $jsonValidEmail);
        $invalidEmailResponse = $this->getGuzzleHttpResponse(200, [], $jsonInvalidEmail);
        $invalidEmailStatusAcceptAllResponse = $this->getGuzzleHttpResponse(200, [], $jsonInvalidEmailStatusAcceptAll);
        $invalidEmailStatusUnknownResponse = $this->getGuzzleHttpResponse(200, [], $jsonInvalidEmailStatusUnknown);

        return [
            [
                $validEmailResponse,
                [
                    'isValid' => true,
                    'isInvalid' => false,
                    'isAcceptAll' => false,
                    'isUnknown' => false,
                    'isDisposable' => false,
                    'isRoleAddress' => false,
                    'getError' => '',
                ]
            ],
            [
                $invalidEmailResponse,
                [
                    'isValid' => false,
                    'isInvalid' => true,
                    'isAcceptAll' => false,
                    'isUnknown' => false,
                    'isDisposable' => false,
                    'isRoleAddress' => false,
                    'getError' => 'Email account invalid',
                ]
            ],
            [
                $invalidEmailStatusAcceptAllResponse,
                [
                    'isValid' => false,
                    'isInvalid' => false,
                    'isAcceptAll' => true,
                    'isUnknown' => false,
                    'isDisposable' => false,
                    'isRoleAddress' => false,
                    'getError' => 'Email account invalid',
                ]
            ],
            [
                $invalidEmailStatusUnknownResponse,
                [
                    'isValid' => false,
                    'isInvalid' => false,
                    'isAcceptAll' => false,
                    'isUnknown' => true,
                    'isDisposable' => false,
                    'isRoleAddress' => false,
                    'getError' => 'Email account invalid',
                ]
            ],
        ];
    }

    /**
     * Creates a new response object based on the parameters
     *
     * @param $statusCode
     * @param $header
     * @param $jsonValidEmail
     * @return \GuzzleHttp\Psr7\Response
     */
    private function getGuzzleHttpResponse($statusCode, $header, $jsonValidEmail)
    {
        $response = new \GuzzleHttp\Psr7\Response(
            $statusCode,
            $header,
            \GuzzleHttp\Psr7\stream_for(json_encode($jsonValidEmail))
        );
        return $response;
    }
}
