<?php

namespace Orkestra\Common\Cryptography;

/**
 * Provides a wrapper for the Mcrypt extension
 */
class Encryptor
{
    /**
     * @var string
     */
    protected $_algorithm;

    /**
     * @var string
     */
    protected $_mode;

    /**
     * @var resource
     */
    private $_module;

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

        $this->_algorithm = $algorithm;
        $this->_mode = $mode;
        $this->_module = mcrypt_module_open($algorithm, '', $mode, '');
        if (!$this->_module) {
            throw new \RuntimeException(sprintf('Could not open mcrypt module for algorithm "%s" in mode "%s"', $algorithm, $mode));
        }
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        mcrypt_module_close($this->_module);
    }

    /**
     * Creates a random initialization vector
     *
     * @return string
     */
    public function createIv()
    {
        return mcrypt_create_iv(mcrypt_enc_get_iv_size($this->_module), MCRYPT_DEV_URANDOM);
    }

    /**
     * Gets the initialization vector size
     *
     * @return int
     */
    public function getIvSize()
    {
        return mcrypt_enc_get_iv_size($this->_module);
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
        mcrypt_generic_init($this->_module, $key, $iv);
        $message = mcrypt_generic($this->_module, $message);
        mcrypt_generic_deinit($this->_module);

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
        mcrypt_generic_init($this->_module, $key, $iv);
        $message = mdecrypt_generic($this->_module, $message);
        mcrypt_generic_deinit($this->_module);

        return rtrim($message, "\0");
    }
}