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

namespace Orkestra\Common\Tests\DBAL\Types;

use Orkestra\Common\Tests\TestCase;

require_once __DIR__ . '/../TestCase.php';

use Doctrine\DBAL\Types\Type;

/**
 * EncryptedStringType Test
 *
 * Tests the functionality of the EncryptedStringType DBAL type
 *
 * @group orkestra
 * @group common
 * @group crypt
 */
class EncryptedStringTypeTest extends TestCase
{
    protected $typesMap;

    protected $type;

    protected $platform;

    protected function setUp()
    {
        parent::setUp();

        $this->typesMap = Type::getTypesMap();

        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typeObjects', array());
        Type::addType('encrypted_string', 'Orkestra\Common\DbalType\EncryptedStringType');

        $this->type = Type::getType('encrypted_string');

        $this->platform = $this->getMockForAbstractClass('Doctrine\DBAL\Platforms\AbstractPlatform');
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typesMap', $this->typesMap);
        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typeObjects', array());
    }

    public function testConversion()
    {
        $this->assertInstanceOf('Orkestra\Common\DbalType\EncryptedStringType', $this->type);

        $this->type->setKey('key');

        $value = 'This is a test';

        $encryptedValue = $this->type->convertToDatabaseValue($value, $this->platform);

        $decryptedValue = $this->type->convertToPHPValue($encryptedValue, $this->platform);

        $this->assertEquals($value, $decryptedValue);
    }
}
