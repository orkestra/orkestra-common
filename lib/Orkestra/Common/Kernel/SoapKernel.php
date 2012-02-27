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
class SoapKernel implements IKernel
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
        }
        catch (\Exception $e) {
            $response = new SoapResponse($e->__toString(), $e, 'HTTP/1.1 500 Internal Server Error');
        }
        
        try {
            $data = $client->__soapCall($request->getSoapAction(), $content);
        }
        catch (\Exception $e) {
            $data = $e;
        }

        $header = $client->__getLastResponseHeaders();
        $raw = $client->__getLastResponse();

        $response = new SoapResponse($raw, $data, $header);
        
        return $response;
    }
}