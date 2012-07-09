<?php

namespace Orkestra\Common\DBAL\Types;

use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Orkestra\Common\Cryptography\Encryptor;


/**
 * Encrypted Type
 *
 * Provides Doctrine DBAL support for encrypted string fields
 */
class EncryptedStringType extends StringType
{
    /**
     * @var \Orkestra\Common\Cryptography\Encryptor
     */
    protected $_encryptor;

    /**
     * @var string
     */
    protected $_key;

    /**
     * Sets the key to be used
     *
     * @param $key
     */
    public function setKey($key)
    {
        $this->_key = $key;
    }

    /**
     * @return \Orkestra\Common\Cryptography\Encryptor
     */
    private function _getEncryptor()
    {
        if (!$this->_encryptor) {
            $this->_encryptor = new Encryptor();
        }

        return $this->_encryptor;
    }

    /**
     * @param mixed $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     *
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        $encryptor = $this->_getEncryptor();

        $iv = $encryptor->createIv();

        return base64_encode($iv . $encryptor->encrypt($value, $this->_key, $iv));
    }

    /**
     * @param mixed $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     *
     * @return mixed
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        $encryptor = $this->_getEncryptor();

        $value = base64_decode($value);

        $len = $encryptor->getIvSize();

        $iv = substr($value, 0, $len);
        $value = substr($value, $len);

        return $encryptor->decrypt($value, $this->_key, $iv);
    }
}
