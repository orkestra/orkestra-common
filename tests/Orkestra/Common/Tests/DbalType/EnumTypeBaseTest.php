<?php

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
