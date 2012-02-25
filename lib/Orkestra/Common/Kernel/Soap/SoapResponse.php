<?php

namespace Orkestra\Common\Kernel\Soap;

use Symfony\Component\HttpFoundation\Response;

/**
 * Soap Response
 *
 * Provides a wrapper for a Response object
 *
 * @package Orkestra
 * @subpackage Common
 */
class SoapResponse extends Response
{
    /**
     * @var object
     */
    protected $_data;
    
    /**
     * Constructor
     *
     * @param string $content Raw response XML
     * @param object $data Transformed response
     * @param string $header Raw response header
     */
    public function __construct($content, $data, $header = '')
    {
        $code = (int)substr($header, 9, 3);
        $headers = $this->_normalizeHeader($header);

        parent::__construct($content, $code, $headers);
        
        $this->_data = $data;
    }
    
    /**
     * Get Data
     *
     * @return object
     */
    public function getData()
    {
        return $this->_data;
    }
    
    /**
     * Normalize Header
     *
     * Converts a string header into a proper associative array
     *
     * @param string $header
     * @return array
     */
    protected function _normalizeHeader($header)
    {
        $headers = array();
        
        $parts = explode("\n", $header);
        
        foreach ($parts as $part) {
            $subParts = explode(':', $part, 1);
            
            if (empty($subParts[1])) {
                continue;
            }
            
            $headers[$subParts[0]] = trim($subParts[1]);
        }
        
        return $headers;
    }
}