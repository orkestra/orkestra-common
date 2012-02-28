<?php

namespace Orkestra\Common\Kernel;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;
    
use Monolog\Logger;

/**
 * Http Kernel
 *
 * This kernel provides a wrapper for cURL to execute a given Request and return
 * a normalized Response object.
 *
 * @package Orkestra
 * @subpackage Common
 */
abstract class KernelBase implements IKernel
{
    protected $_logger;
    
    public function __construct(Logger $logger = null)
    {
        $this->_logger = $logger;
    }
    
    protected function _log($message)
    {
        if (!empty($this->_logger)) {
            $this->_logger->info($message);
        }
    }
}