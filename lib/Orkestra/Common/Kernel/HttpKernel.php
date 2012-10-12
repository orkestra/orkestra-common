<?php

namespace Orkestra\Common\Kernel;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

/**
 * Http Kernel
 *
 * This kernel provides a wrapper for cURL to execute a given Request and return
 * a normalized Response object.
 *
 * @package Orkestra
 * @subpackage Common
 */
class HttpKernel extends KernelBase
{
    private $caBundlePath;

    /**
     * Sets the path to the Certificate Authority Bundle file
     *
     * @param string $path
     */
    public function setCaBundlePath($path)
    {
        $this->caBundlePath = $path;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request)
    {
        $ch = curl_init($request->getUri());

        $headers = $this->_convertHeadersToCurlFormat($request->headers->all());
        $params = $request->request->all();

        if ($request->getMethod() == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
        } elseif ($request->getMethod() != 'GET') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request->getMethod());
        }

        if (!empty($this->caBundlePath)) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_CAINFO, $this->caBundlePath);
            curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        $rawResponse = curl_exec($ch);

        $info = curl_getinfo($ch);

        $headers = explode("\n", substr($rawResponse, 0, $info['header_size']));
        $body = ltrim(substr($rawResponse, $info['header_size']));
        $code = $info['http_code'] ?: 500;

        $this->_log('HttpKernel: Request to ' . $request->getUri());
        $this->_log('HttpKernel: Request: ' . http_build_query($params));
        $this->_log('HttpKernel: Response: ' . $body);

        $response = new Response($body, $code, $headers);

        return $response;
    }

    /**
     * Convert Headers To Curl Format
     *
     * Converts a Request object's header format into the format used by cURL
     *
     * @param array $headers
     * @return array
     */
    protected function _convertHeadersToCurlFormat(array $headers)
    {
        $result = array();

        foreach ($headers as $directive => $value) {
            if (is_array($value)) {
                $value = $value[0];
            }

            $result[] = "{$directive}: {$value}";
        }

        return $result;
    }
}
