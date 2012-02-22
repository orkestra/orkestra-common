<?php

namespace Orkestra\Common\Tests\DBAL\Types;

use Doctrine\DBAL\Types\Type;

use Orkestra\Common\Tests\TestCase,
    Orkestra\Common\Type\Date,
    Orkestra\Common\Type\NullDateTime;

/**
 * DateType Test
 *
 * Tests the functionality of the DateType DBAL datatype
 */
class DateTypeTest extends TestCase
{
    protected $_typesMap;
    
    protected $_dateType;
    
    protected $_platform;
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->_typesMap = Type::getTypesMap();
        
        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typeObjects', array());
        Type::overrideType('date', 'Orkestra\Common\DBAL\Types\DateType');
        
        $this->_dateType = Type::getType('date');
        
        $this->_platform = $this->getMockForAbstractClass('Doctrine\DBAL\Platforms\AbstractPlatform');
        $this->_platform->expects($this->any())
                        ->method('getDateFormatString')
                        ->will($this->returnValue('Y-m-d'));
    }

    protected function tearDown()
    {
        parent::tearDown();
        
        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typesMap', $this->_typesMap);
        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typeObjects', array());
    }
    
    public function testConvertToDatabaseReturnsDateString()
    {
        $date = Date::createFromFormat('Y-m-d', '2011-01-01');

        $this->assertEquals('2011-01-01', $this->_dateType->convertToDatabaseValue($date, $this->_platform));
    }
       
    public function testConvertToDatabaseWithNullReturnsNull()
    {
        $date = null;
        
        $this->assertEquals(null, $this->_dateType->convertToDatabaseValue($date, $this->_platform));
    }
    
    public function testConvertToDatabaseWithNullDateTimeReturnsNull()
    {
        $date = new NullDateTime();
        
        $this->assertEquals(null, $this->_dateType->convertToDatabaseValue($date, $this->_platform));
    }
    
    public function testConvertToPhpValueReturnsDate()
    {
        $date = '2011-01-01';
        
        $date = $this->_dateType->convertToPHPValue($date, $this->_platform);
        
        $this->assertInstanceOf('Orkestra\Common\Type\Date', $date);
    }
    
    public function testConvertNullToPhpValueReturnsNullDateTime()
    {
        $date = null;
        
        $date = $this->_dateType->convertToPHPValue($date, $this->_platform);
        
        $this->assertInstanceOf('Orkestra\Common\Type\NullDateTime', $date);
    }
}