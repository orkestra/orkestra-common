<?php

namespace Orkestra\Common\Kernel;

use Symfony\Component\HttpFoundation\Request;

/**
 * Kernel Interface
 *
 * A Kernel, in this context, is responsible for transforming (or executing) a
 * Request object into a Response object
 *
 * @package Orkestra
 * @subpackage Transactor
 */
interface IKernel
{
    /**
     * Transform the Request into a Response
     *
     * @param Symfony\Component\HttpFoundation\Request $request
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request);
}