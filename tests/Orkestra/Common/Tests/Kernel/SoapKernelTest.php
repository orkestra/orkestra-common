<?php

namespace Orkestra\Common\Tests\Kernel;

use Orkestra\Common\Kernel\SoapKernel,
	Orkestra\Common\Kernel\Soap\SoapRequest;

/**
 * SoapKernel Test
 *
 * Tests the functionality provided by the SoapRequest class
 *
 * @group orkestra
 * @group common
 * @group integration
 */
class SoapKernelTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $request = SoapRequest::createSoapRequest('http://www.webservicex.net/length.asmx?WSDL', 'ChangeLengthUnit', array('LengthValue' => 10, 'fromLengthUnit' => 'Feet', 'toLengthUnit' => 'Inches'));

        $kernel = new SoapKernel();

        $response = $kernel->handle($request);

        $this->assertInstanceOf('Orkestra\Common\Kernel\Soap\SoapResponse', $response);

        $data = $response->getData();

        $this->assertEquals(120, $data->ChangeLengthUnitResult);
    }
}
