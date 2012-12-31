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
