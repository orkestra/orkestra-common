<?php

namespace Orkestra\Common\Tests\DBAL\Types;

require __DIR__ . '/../../../../../bootstrap.php';

use Doctrine\DBAL\Types\Type;

use Orkestra\Common\Tests\TestCase,
	Orkestra\Common\Type\Enum,
	Orkestra\Common\DBAL\Types\EnumTypeBase;

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
    protected $_typesMap;
    
    protected $_enumType;
    
    protected $_platform;
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->_typesMap = Type::getTypesMap();
        
        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typeObjects', array());
        Type::addType('enum.test', 'Orkestra\Common\Tests\DBAL\Types\TestEnumEnumType');
        
        $this->_enumType = Type::getType('enum.test');
        
        $this->_platform = $this->getMockForAbstractClass('Doctrine\DBAL\Platforms\AbstractPlatform');
    }

    protected function tearDown()
    {
        parent::tearDown();
        
        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typesMap', $this->_typesMap);
        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typeObjects', array());
    }
    
    public function testConvertToDatabaseReturnsString()
    {
        $this->assertInstanceOf('Orkestra\Common\Tests\DBAL\Types\TestEnumEnumType', $this->_enumType);
        
        $enum = new TestEnum(TestEnum::Value); 

        $this->assertEquals('Value', $this->_enumType->convertToDatabaseValue($enum, $this->_platform));
    }

    public function testConvertToPhpValueReturnsEnum()
    {
        $value = 'Value';
        
        $enum = $this->_enumType->convertToPHPValue($value, $this->_platform);
        
        $this->assertInstanceOf('Orkestra\Common\Tests\DBAL\Types\TestEnum', $enum);
        $this->assertEquals('Value', $enum->getValue());
    }
    
    public function testConvertNullToPhpValueReturnsNull()
    {
        $value = null;
        
        $enum = $this->_enumType->convertToPHPValue($value, $this->_platform);
        
        $this->assertNull($enum);
    }
    
    public function testConvertEmptyStringToPhpValueReturnsNull()
    {
        $value = '';
        
        $enum = $this->_enumType->convertToPHPValue($value, $this->_platform);
        
        $this->assertNull($enum);
    }
    
    public function testConvertInvalidValueToPhpValueThrowsException()
    {
        $this->setExpectedException('Doctrine\DBAL\Types\ConversionException', 'Could not convert database value "Invalid Value" to Doctrine Type test.enum');
        
        $value = 'Invalid Value';
        
        $enum = $this->_enumType->convertToPHPValue($value, $this->_platform);
    }
}

class TestEnumEnumType extends EnumTypeBase
{
    protected $_name = 'test.enum';
    protected $_class = 'Orkestra\Common\Tests\DBAL\Types\TestEnum';
}

class TestEnum extends Enum
{
    const Value = 'Value';
}