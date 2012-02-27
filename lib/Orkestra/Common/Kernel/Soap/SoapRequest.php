<?php

namespace Orkestra\Common\Kernel\Soap;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\HeaderBag;

/**
 * Soap Request
 *
 * Provides a wrapper for a Request object
 *
 * @package Orkestra
 * @subpackage Common
 */
class SoapRequest extends Request
{
    /**
     * @var string
     */
    protected $_soapAction;
    
    /**
     * Create Soap Request
     *
     * @param string $uri
     * @param string $soapAction
     * @param mixed $arguments
     * @param array $headers
     * @return Orkestra\Common\Kernel\Soap\SoapRequest
     */
    public static function createSoapRequest($uri, $soapAction, $arguments, $headers = array())
    {
        $request = parent::create($uri, 'POST', array(), array(), array(), array(), array($arguments));
        $request->_soapAction = $soapAction;
        
        foreach ($headers as $key => $value) {
            $request->headers->set($key, $value);
        }
        
        return $request;
    }
    
    /**
     * Set SoapAction
     *
     * @param string $action
     */
    public function setSoapAction($action)
    {
        $this->_soapAction = $action;
    }
    
    /**
     * Get SoapAction
     *
     * @return string
     */
    public function getSoapAction()
    {
        return $this->_soapAction;
    }
}