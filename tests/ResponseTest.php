<?php

class ResponseTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
        $responseMock = $this->getMockBuilder('\GuzzleHttp\Message\Response')
              ->setMethods(['json'])
              ->getMock();
        $this->class = new \REINetwork\BriteVerify\Response($responseMock);
    }


    public function testClass()
    {


       $this->assertSame(true, $this->class->isValid());
       $this->assertSame(true, $this->class->isInvalid());
       $this->assertSame(true, $this->class->isAcceptAll());
       $this->assertSame(true, $this->class->isUnknown());
    }

}
