<?php
namespace REINetwork\BriteVerify;

/**
 * A representation of the BriteVerify response for an email validation call.
 */
class Response
{
    protected $response;

    public $address;
    public $account;
    public $domain;
    public $status;
    public $connected;
    public $disposable;
    public $roleAddress;
    public $errorCode;
    public $error;
    public $duration;

    public function __construct(\GuzzleHttp\Message\Response $response)
    {
        $this->response = $response;

        $this->parse($response);
    }

    /**
     * Maps the JSON response values into this class properties.
     * @param  \GuzzleHttp\Message\Response  $response.
     */
    protected function parse(\GuzzleHttp\Message\Response $response)
    {
        $json = $response->json();

        $this->address = $json['address'];
        $this->account = $json['account'];
        $this->domain = $json['domain'];
        $this->status = strtolower($json['status']);
        $this->connected = $json['connected'];
        $this->disposable = $json['disposable'];
        $this->roleAddress = $json['role_address'];
        $this->errorCode = isset($json['error_code']) ? $json['error_code'] : '';
        $this->error = isset($json['error']) ? $json['error'] : '';
        $this->duration = isset($json['duration']) ? $json['duration'] : null;
    }

    public function getError()
    {
        return $this->error;
    }

    /**
     * Check to see if email passed validation
     *
     * @return bool
     */
    public function isValid()
    {
        return ($this->status === 'valid');
    }

    /**
     * Check to see if email failed validation
     *
     * @return bool
     */
    public function isInvalid()
    {
        return ($this->status === 'invalid');
    }

    /**
     * Check to see if domain accepts any address
     *
     * @return bool
     */
    public function isAcceptAll()
    {
        return ($this->status === 'accept_all');
    }

    /**
     * Check to see if the request did not complete.
     *
     * @return bool
     */
    public function isUnknown()
    {
        return ($this->status === 'unknown');
    }

    /**
     * Checks to see if the address is a "throw away."
     * @example user@mailinator.com
     *
     * @return bool
     */
    public function isDisposable()
    {
        return ($this->disposable === true);
    }

    /**
     * Checks to see if the address is a role address
     * @example postmaster@domain.com
     * @example abuse@domain.com
     *
     * @return bool
     */
    public function isRoleAddress()
    {
        return ($this->roleAddress === true);
    }

    /**
     * Return the raw HTTP request.
     *
     * @return \GuzzleHttp\Message\Response
     */
    public function getHttpResponse()
    {
        return (string) $this->response;
    }
}
