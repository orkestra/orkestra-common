<?php

namespace Orkestra\Common\Tests\Kernel\Soap;

require __DIR__ . '/../../../../../bootstrap.php';

use Orkestra\Common\Tests\TestCase,
	Orkestra\Common\Kernel\Soap\SoapRequest;

/**
 * SoapRequest Test
 *
 * Tests the functionality provided by the SoapRequest class
 *
 * @group orkestra
 * @group common
 */
class SoapRequestTest extends TestCase
{
    public function testCreate()
    {
        $request = SoapRequest::createSoapRequest('http://www.example.com/', 'test', array('param' => 'value'), array('Header' => 'Value'));
        
        $this->assertInstanceOf('Orkestra\Common\Kernel\Soap\SoapRequest', $request);
        $this->assertEquals('test', $request->getSoapAction());
        $this->assertEquals('http://www.example.com/', $request->getUri());
        $this->assertEquals(array(array('param' => 'value')), $request->getContent());
        $this->assertTrue($request->headers->has('Header'));
    }
}
