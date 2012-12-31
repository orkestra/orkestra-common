<?php

namespace Orkestra\Common\DbalType;

use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
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
    protected $encryptor;

    /**
     * @var string
     */
    protected $key;

    public function setKey($key)
    {
        $this->key = $key;
    }

    private function _getEncryptor()
    {
        if (!$this->encryptor) {
            $this->encryptor = new Encryptor();
        }

        return $this->encryptor;
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        $encryptor = $this->_getEncryptor();

        $iv = $encryptor->createIv();

        return base64_encode($iv . $encryptor->encrypt($value, $this->key, $iv));
    }

    /**
     * {@inheritdoc}
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

        return $encryptor->decrypt($value, $this->key, $iv);
    }
}
