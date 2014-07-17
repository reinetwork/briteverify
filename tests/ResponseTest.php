<?php

class ResponseTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider dataProvider
     */
    public function testClass($json, $expects)
    {
      $responseMock = $this->getMockBuilder('\GuzzleHttp\Message\Response')
          ->disableOriginalConstructor()
          ->setMethods(['json'])
          ->getMock();

      $responseMock->expects($this->once())
          ->method('json')
          ->will($this->returnValue($json));

      $this->class = new \REINetwork\BriteVerify\Response($responseMock);
      $this->assertSame($expects['isValid'], $this->class->isValid());
      $this->assertSame($expects['isInvalid'], $this->class->isInvalid());
      $this->assertSame($expects['isAcceptAll'], $this->class->isAcceptAll());
      $this->assertSame($expects['isUnknown'], $this->class->isUnknown());
      $this->assertSame($expects['isDisposable'], $this->class->isDisposable());
      $this->assertSame($expects['isRoleAddress'], $this->class->isRoleAddress());
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
     * unknown: For some reason we cannot verify valid or invalid. Most of the time a domain did not respond quickly enough.
     * accept_all: These are domains that respond to every verification request in the affirmative, and therefore cannot be fully verified.
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

        return [
            [
                $jsonValidEmail,
                [
                    'isValid' => true,
                    'isInvalid' => false,
                    'isAcceptAll' => false,
                    'isUnknown' => false,
                    'isDisposable' => false,
                    'isRoleAddress' => false,
                ]
            ],
            [
                $jsonInvalidEmail,
                [
                    'isValid' => false,
                    'isInvalid' => true,
                    'isAcceptAll' => false,
                    'isUnknown' => false,
                    'isDisposable' => false,
                    'isRoleAddress' => false,
                ]
            ],
            [
                $jsonInvalidEmailStatusAcceptAll,
                [
                    'isValid' => false,
                    'isInvalid' => false,
                    'isAcceptAll' => true,
                    'isUnknown' => false,
                    'isDisposable' => false,
                    'isRoleAddress' => false,
                ]
            ],
            [
                $jsonInvalidEmailStatusUnknown,
                [
                    'isValid' => false,
                    'isInvalid' => false,
                    'isAcceptAll' => false,
                    'isUnknown' => true,
                    'isDisposable' => false,
                    'isRoleAddress' => false,
                ]
            ],
        ];
    }

}
