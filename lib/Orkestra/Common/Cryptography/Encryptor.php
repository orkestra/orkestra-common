<?php

/*
 * Copyright (c) 2012 Orkestra Community
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */

namespace Orkestra\Common\Cryptography;

/**
 * Provides a wrapper for the Mcrypt extension
 */
class Encryptor
{
    /**
     * @var string
     */
    protected $algorithm;

    /**
     * @var string
     */
    protected $mode;

    /**
     * @var resource
     */
    private $module;

    /**
     * Constructor
     *
     * @param string $algorithm
     * @param string $mode
     *
     * @throws \RuntimeException if the Mcrypt module is not loaded, or if the encryption module fails to initialize
     */
    public function __construct($algorithm = MCRYPT_RIJNDAEL_256, $mode = MCRYPT_MODE_CBC)
    {
        if (!function_exists('mcrypt_module_open')) {
            throw new \RuntimeException('The Encryptor class relies on the Mcrypt extension, which is not available on your PHP installation.');
        }

        $this->algorithm = $algorithm;
        $this->mode = $mode;
        $this->module = mcrypt_module_open($algorithm, '', $mode, '');
        if (!$this->module) {
            throw new \RuntimeException(sprintf('Could not open mcrypt module for algorithm "%s" in mode "%s"', $algorithm, $mode));
        }
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        mcrypt_module_close($this->module);
    }

    /**
     * Creates a random initialization vector
     *
     * @return string
     */
    public function createIv()
    {
        return mcrypt_create_iv(mcrypt_enc_get_iv_size($this->module), MCRYPT_DEV_URANDOM);
    }

    /**
     * Gets the initialization vector size
     *
     * @return int
     */
    public function getIvSize()
    {
        return mcrypt_enc_get_iv_size($this->module);
    }

    /**
     * Gets the maximum key size
     *
     * @return int
     */
    public function getKeySize()
    {
        return mcrypt_enc_get_key_size($this->module);
    }

    /**
     * Encrypts a message
     *
     * @param $message
     * @param $key
     * @param $iv
     *
     * @return string
     */
    public function encrypt($message, $key, $iv)
    {
        if (!empty($message)) {
            mcrypt_generic_init($this->module, $key, $iv);
            $message = mcrypt_generic($this->module, $message);
            mcrypt_generic_deinit($this->module);
        }

        return $message;
    }

    /**
     * Decrypts a message
     *
     * @param $message
     * @param $key
     * @param $iv
     *
     * @return string
     */
    public function decrypt($message, $key, $iv)
    {
        if (!empty($message)) {
            mcrypt_generic_init($this->module, $key, $iv);
            $message = mdecrypt_generic($this->module, $message);
            mcrypt_generic_deinit($this->module);
        }

        return rtrim($message, "\0");
    }
}
