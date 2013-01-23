<?php

/*
 * This file is part of the Orkestra Common package.
 *
 * Copyright (c) Orkestra Community
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Orkestra\Common\Tests\Type;

use Orkestra\Common\Type\DateTime;

/**
 * Unit tests for DateTime
 *
 * @group orkestra
 * @group common
 * @group type
 */
class DateTimeTest extends \PHPUnit_Framework_TestCase
{
    private static $systemTimezone;

    /**
     * Ensures that a known timezone is set for the server
     *
     * @static
     */
    public static function setUpBeforeClass()
    {
        self::$systemTimezone = date_default_timezone_get();
        date_default_timezone_set('Etc/GMT');
    }

    /**
     * Resets the environment to the configured timezone
     *
     * @static
     */
    public static function tearDownAfterClass()
    {
        date_default_timezone_set(self::$systemTimezone);
    }

    /**
     * Resets the DateTime configurations
     */
    protected function setUp()
    {
        DateTime::setUserTimezone(null);
        DateTime::setServerTimezone(null);
        DateTime::setDefaultFormat('');
    }

    public function testGetConfiguredTimezoneReturnsSystemConfigured()
    {
        $this->assertEquals('Etc/GMT', DateTime::getServerTimezone()->getName());
        $this->assertEquals('Etc/GMT', DateTime::getUserTimezone()->getName());
    }

    public function testCreateFromDefaultFormatNoTimezone()
    {
        DateTime::setDefaultFormat('Y-m-d H:i:s');

        $dt = DateTime::createFromDefaultFormat('2012-01-01 17:25:30');
        $this->assertEquals('2012-01-01 17:25:30', $dt->format('Y-m-d H:i:s'));
        $this->assertEquals('Etc/GMT', $dt->getTimezone()->getName());
    }

    public function testCreateFromDefaultFormatWithTimezone()
    {
        DateTime::setDefaultFormat('Y-m-d H:i:s');

        $dt = DateTime::createFromDefaultFormat('2012-01-01 17:25:30', new \DateTimeZone('America/New_York'));
        $this->assertEquals('2012-01-01 17:25:30', $dt->format('Y-m-d H:i:s'));
        $this->assertEquals('America/New_York', $dt->getTimezone()->getName());
    }

    public function testConstructorNoTimezone()
    {
        $dt = new DateTime('2012-01-01 17:25:30');
        $this->assertEquals('2012-01-01 17:25:30', $dt->format('Y-m-d H:i:s'));
        $this->assertEquals('Etc/GMT', $dt->getTimezone()->getName());
    }

    public function testConstructorWithTimezone()
    {
        $dt = new DateTime('2012-01-01 17:25:30', new \DateTimeZone('America/New_York'));
        $this->assertEquals('2012-01-01 17:25:30', $dt->format('Y-m-d H:i:s'));
        $this->assertEquals('America/New_York', $dt->getTimezone()->getName());
    }

    public function testConversion()
    {
        DateTime::setServerTimezone(new \DateTimeZone('Etc/GMT'));
        DateTime::setUserTimezone(new \DateTimeZone('America/Boise'));

        $dt = new DateTime('2012-01-01 17:25:30', new \DateTimeZone('America/New_York'));
        $this->assertEquals('2012-01-01 17:25:30', $dt->format('Y-m-d H:i:s'));

        $dt->toUserTime();
        $this->assertEquals('America/Boise', $dt->getTimezone()->getName());
        $this->assertEquals('2012-01-01 15:25:30', $dt->format('Y-m-d H:i:s'));

        $dt->toServerTime();
        $this->assertEquals('Etc/GMT', $dt->getTimezone()->getName());
        $this->assertEquals('2012-01-01 22:25:30', $dt->format('Y-m-d H:i:s'));
    }
}
