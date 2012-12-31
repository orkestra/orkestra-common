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
