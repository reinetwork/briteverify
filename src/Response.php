<?php

namespace REINetwork\BriteVerify;

class Response
{
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
        $this->parse($response);
    }

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
        $this->errorCode = $json['error_code'];
        $this->error = $json['error'];
        $this->duration = $json['duration'];
    }

    public function isValid()
    {
        return ($this->status === 'valid');
    }

    public function isInvalid()
    {
        return ($this->status === 'invalid');
    }

    public function isAcceptAll()
    {
        return ($this->status === 'accept_all');
    }

    public function isUnknown()
    {
        return ($this->status === 'unknown');
    }

    public function isDisposable()
    {
        return ($this->disposable === true);
    }

    public function isRoleAddress()
    {
        return ($this->roleAddress === true);
    }

}
