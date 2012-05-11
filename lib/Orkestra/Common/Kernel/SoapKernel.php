<?php

namespace Orkestra\Common\Kernel;

use Symfony\Component\HttpFoundation\Request;
    
use Orkestra\Common\Kernel\Soap\SoapRequest,
    Orkestra\Common\Kernel\Soap\SoapResponse,
    Orkestra\Common\Exception\KernelException;

/**
 * Soap Kernel
 *
 * This kernel provides a wrapper for SoapClient to execute a given Request and return
 * a normalized Response object.
 *
 * @package Orkestra
 * @subpackage Common
 */
class SoapKernel extends KernelBase
{
    /**
     * {@inheritdoc}
     *
     * @return Orkestra\Common\Kernel\Soap\SoapResponse
     */
    public function handle(Request $request)
    {
        if (!$request instanceof SoapRequest) {
            throw new KernelException(sprintf('SoapKernel expects argument 1 to be of type Orkestra\Common\Kernel\Soap\SoapRequest, type %s given', get_class($request)));
        }
        
        try {
            $client = new \SoapClient($request->getUri(), array(
            	"trace" => true,
            	"exceptions" => true,
            ));
        
            $content = $request->getContent();

            try {
                $data = $client->__soapCall($request->getSoapAction(), $content);
            }
            catch (\Exception $e) {
                $data = $e;
            }

            $this->_log('SoapKernel: Request to ' . $request->getUri());
            $this->_log('SoapKernel: Request: ' . $client->__getLastRequest());
            $this->_log('SoapKernel: Response: ' . $client->__getLastResponse());

            $header = $client->__getLastResponseHeaders();
            $raw = $client->__getLastResponse();

            $response = new SoapResponse($raw, $data, $header);
        }
        catch (\Exception $e) {
            $response = new SoapResponse($e->__toString(), $e, 'HTTP/1.1 500 Internal Server Error');
        }

        return $response;
    }
}