<?php

namespace Orkestra\Common\Tests\DBAL\Types;

require_once __DIR__ . '/../../TestCase.php';

use Doctrine\DBAL\Types\Type;

use Orkestra\Common\Tests\TestCase,
    Orkestra\Common\Type\Date,
    Orkestra\Common\Type\NullDateTime;

/**
 * DateType Test
 *
 * Tests the functionality of the DateType DBAL datatype
 *
 * @group orkestra
 * @group common
 */
class DateTypeTest extends TestCase
{
    protected $typesMap;

    protected $dateType;

    protected $platform;

    protected function setUp()
    {
        parent::setUp();

        $this->typesMap = Type::getTypesMap();

        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typeObjects', array());
        Type::overrideType('date', 'Orkestra\Common\DBAL\Types\DateType');

        $this->dateType = Type::getType('date');

        $this->platform = $this->getMockForAbstractClass('Doctrine\DBAL\Platforms\AbstractPlatform');
        $this->platform->expects($this->any())
                        ->method('getDateFormatString')
                        ->will($this->returnValue('Y-m-d'));
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typesMap', $this->typesMap);
        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typeObjects', array());
    }

    public function testConvertToDatabaseReturnsDateString()
    {
        $date = Date::createFromFormat('Y-m-d', '2011-01-01');

        $this->assertEquals('2011-01-01', $this->dateType->convertToDatabaseValue($date, $this->platform));
    }

    public function testConvertToDatabaseWithNullReturnsNull()
    {
        $date = null;

        $this->assertEquals(null, $this->dateType->convertToDatabaseValue($date, $this->platform));
    }

    public function testConvertToDatabaseWithNullDateTimeReturnsNull()
    {
        $date = new NullDateTime();

        $this->assertEquals(null, $this->dateType->convertToDatabaseValue($date, $this->platform));
    }

    public function testConvertToPhpValueReturnsDate()
    {
        $date = '2011-01-01';

        $date = $this->dateType->convertToPHPValue($date, $this->platform);

        $this->assertInstanceOf('Orkestra\Common\Type\Date', $date);
    }

    public function testConvertNullToPhpValueReturnsNullDateTime()
    {
        $date = null;

        $date = $this->dateType->convertToPHPValue($date, $this->platform);

        $this->assertInstanceOf('Orkestra\Common\Type\NullDateTime', $date);
    }
}
