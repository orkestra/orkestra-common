<?php

/*
 * This file is part of the Orkestra Common package.
 *
 * Copyright (c) Orkestra Community
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Orkestra\Common\Tests\Cryptography;

use Orkestra\Common\Cryptography\Encryptor;

/**
 * Encryptor Test
 *
 * Tests the functionality provided by the Encryptor
 *
 * @group orkestra
 * @group common
 */
class EncryptorTest extends \PHPUnit_Framework_TestCase
{
    public function testEncryptor()
    {
        $encryptor = new Encryptor();

        $iv = $encryptor->createIv();

        $encrypted = $encryptor->encrypt('This is a message', 'abc123', $iv);

        $decrypted = $encryptor->decrypt($encrypted, 'abc123', $iv);

        $this->assertEquals('This is a message', $decrypted);
    }

    public function testEmptyString()
    {
        $encryptor = new Encryptor();

        $iv = $encryptor->createIv();

        $encrypted = $encryptor->encrypt('', 'abc123', $iv);

        $decrypted = $encryptor->decrypt($encrypted, 'abc123', $iv);

        $this->assertEquals('', $decrypted);
    }
}
