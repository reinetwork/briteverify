<?php

class ResponseTest extends PHPUnit_Framework_TestCase
{
    public function testClass()
    {
      $responseMock = $this->getMockBuilder('\GuzzleHttp\Message\Response')
          ->disableOriginalConstructor()
          ->setMethods(['json'])
          ->getMock();
      $json = [
          'address' => 'johndoe@briteverify.com',
          'account' => 'johndoe',
          'domain' => 'briteverify.com',
          'status' => 'invalid',
          'connected' => null,
          'disposable' => 'false',
          'role_address' => 'email@address.com',
          'error_code' => 'email_account_invalid',
          'error' => 'Email account invalid',
          'duration' => 0.0000000000,
      ];
      $responseMock->expects($this->once())
          ->method('json')
          ->will($this->returnValue($json));

      $this->class = new \REINetwork\BriteVerify\Response($responseMock);
      $this->assertSame(false, $this->class->isValid());
      $this->assertSame(true, $this->class->isInvalid());
      $this->assertSame(false, $this->class->isAcceptAll());
      $this->assertSame(false, $this->class->isUnknown());
    }

}
