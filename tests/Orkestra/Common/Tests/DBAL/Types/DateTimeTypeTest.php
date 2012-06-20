<?php

namespace Orkestra\Common\Tests\DBAL\Types;

require __DIR__ . '/../../../../../bootstrap.php';

use Doctrine\DBAL\Types\Type;

use Orkestra\Common\Tests\TestCase,
    Orkestra\Common\Type\DateTime,
    Orkestra\Common\Type\NullDateTime;

/**
 * DateTimeType Test
 *
 * Tests the functionality of the DateTimeType DBAL type
 *
 * @group orkestra
 * @group common
 */
class DateTimeTypeTest extends TestCase
{
    protected $_typesMap;

    protected $_dateTimeType;

    protected $_platform;

    protected function setUp()
    {
        parent::setUp();

        $this->_typesMap = Type::getTypesMap();

        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typeObjects', array());
        Type::overrideType('datetime', 'Orkestra\Common\DBAL\Types\DateTimeType');

        $this->_dateTimeType = Type::getType('datetime');

        $this->_platform = $this->getMockForAbstractClass('Doctrine\DBAL\Platforms\AbstractPlatform');
        $this->_platform->expects($this->any())
                        ->method('getDateTimeFormatString')
                        ->will($this->returnValue('Y-m-d'));

        DateTime::setServerTimezone(new \DateTimeZone('Etc/GMT'));
        DateTime::setUserTimezone(new \DateTimeZone('America/Boise'));
        DateTime::setDefaultFormat('m/d/y h:i:s a');
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typesMap', $this->_typesMap);
        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typeObjects', array());
    }

    public function testConvertToDatabaseReturnsServerTime()
    {
        $this->assertInstanceOf('Orkestra\Common\DBAL\Types\DateTimeType', $this->_dateTimeType);

        $datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2011-01-01 08:30:00');

        // Force switch to local time
        $datetime->toUserTime();
        $this->assertEquals('2011-01-01 01:30:00', $datetime->format('Y-m-d H:i:s'));

        $this->assertEquals('2011-01-01 08:30:00', $this->_dateTimeType->convertToDatabaseValue($datetime, $this->_platform));
    }

    public function testConvertToDatabaseWithNullReturnsNull()
    {
        $datetime = null;

        $this->assertEquals(null, $this->_dateTimeType->convertToDatabaseValue($datetime, $this->_platform));
    }

    public function testConvertToDatabaseWithNullDateTimeReturnsNull()
    {
        $datetime = new NullDateTime();
        $this->assertEquals(null, $this->_dateTimeType->convertToDatabaseValue($datetime, $this->_platform));
    }

    public function testConvertToPhpValueReturnsDateTime()
    {
        $date = '2011-01-01 12:00:00';

        $datetime = $this->_dateTimeType->convertToPHPValue($date, $this->_platform);

        $this->assertInstanceOf('Orkestra\Common\Type\DateTime', $datetime);
    }

    public function testConvertNullToPhpValueReturnsNullDateTime()
    {
        $date = null;

        $datetime = $this->_dateTimeType->convertToPHPValue($date, $this->_platform);

        $this->assertInstanceOf('Orkestra\Common\Type\NullDateTime', $datetime);
    }
}
