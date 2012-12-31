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

use Doctrine\DBAL\Types\Type;

require_once __DIR__ . '/../TestCase.php';

use Orkestra\Common\Tests\TestCase,
    Orkestra\Common\Type\Enum,
    Orkestra\Common\DbalType\EnumTypeBase;

/**
 * EnumTypeBase Test
 *
 * Tests the functionality provided by the EnumTypeBase class
 *
 * @group orkestra
 * @group common
 */
class EnumTypeBaseTest extends TestCase
{
    protected $typesMap;

    protected $enumType;

    protected $platform;

    protected function setUp()
    {
        parent::setUp();

        $this->typesMap = Type::getTypesMap();

        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typeObjects', array());
        Type::addType('enum.test', 'Orkestra\Common\Tests\DBAL\Types\TestEnumEnumType');

        $this->enumType = Type::getType('enum.test');

        $this->platform = $this->getMockForAbstractClass('Doctrine\DBAL\Platforms\AbstractPlatform');
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typesMap', $this->typesMap);
        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typeObjects', array());
    }

    public function testConvertToDatabaseReturnsString()
    {
        $this->assertInstanceOf('Orkestra\Common\Tests\DBAL\Types\TestEnumEnumType', $this->enumType);

        $enum = new TestEnum(TestEnum::Value);

        $this->assertEquals('Value', $this->enumType->convertToDatabaseValue($enum, $this->platform));
    }

    public function testConvertToPhpValueReturnsEnum()
    {
        $value = 'Value';

        $enum = $this->enumType->convertToPHPValue($value, $this->platform);

        $this->assertInstanceOf('Orkestra\Common\Tests\DBAL\Types\TestEnum', $enum);
        $this->assertEquals('Value', $enum->getValue());
    }

    public function testConvertNullToPhpValueReturnsNull()
    {
        $value = null;

        $enum = $this->enumType->convertToPHPValue($value, $this->platform);

        $this->assertNull($enum);
    }

    public function testConvertEmptyStringToPhpValueReturnsNull()
    {
        $value = '';

        $enum = $this->enumType->convertToPHPValue($value, $this->platform);

        $this->assertNull($enum);
    }

    public function testConvertInvalidValueToPhpValueThrowsException()
    {
        $this->setExpectedException('Doctrine\DBAL\Types\ConversionException', 'Could not convert database value "Invalid Value" to Doctrine Type test.enum');

        $value = 'Invalid Value';

        $enum = $this->enumType->convertToPHPValue($value, $this->platform);
    }
}

class TestEnumEnumType extends EnumTypeBase
{
    protected $name = 'test.enum';
    protected $class = 'Orkestra\Common\Tests\DBAL\Types\TestEnum';
}

class TestEnum extends Enum
{
    const Value = 'Value';
}
