<?php

/*
 * This file is part of the Orkestra Common package.
 *
 * Copyright (c) Orkestra Community
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Orkestra\Common\Type;

use Orkestra\Common\Exception\TypeException;
use DateTimeZone;

/**
 * Extends PHP's native DateTime to allow simplified conversion to and from user/server time
 */
class DateTime extends \DateTime
{
    /**
     * @var \DateTimeZone $serverTimezone The server's local timezone
     */
    private static $serverTimezone;

    /**
     * @var \DateTimeZone $localTimezone The user's local timezone
     */
    private static $localTimezone;

    /**
     * @var string $defaultFormat The default format
     */
    private static $defaultFormat;

    /**
     * Create From Format
     *
     * @param string             $format
     * @param string             $time
     * @param \DateTimeZone|null $timezone
     *
     * @throws \Orkestra\Common\Exception\TypeException
     * @return \Orkestra\Common\Type\DateTime
     */
    public static function createFromFormat($format, $time, $timezone = null)
    {
        if (null === $timezone) {
            $timezone = self::getServerTimezone();
        }

        if (null === $timezone) {
            // This is necessary due to how native DateTime handles passing null for a timezone (it doesnt)
            $parent = parent::createFromFormat($format, $time);
        } else {
            $parent = parent::createFromFormat($format, $time, $timezone);
        }

        if (empty($parent)) {
            throw new TypeException('Could not create DateTime from the given format');
        }

        $datetime = new self('@' . $parent->getTimestamp());
        if (null !== $timezone) {
            $datetime->setTimezone($timezone);
        }

        return $datetime;
    }

    /**
     * Create From Default Format
     *
     * Attempts to create a new DateTime object using a given date value and the configured default
     * datetime format
     *
     * @param string             $datetime
     * @param \DateTimeZone|null $timezone
     *
     * @return \Orkestra\Common\Type\DateTime
     */
    public static function createFromDefaultFormat($datetime, $timezone = null)
    {
        return self::createFromFormat(self::$defaultFormat, $datetime, $timezone);
    }

    /**
     * Converts a PHP format string to Javascript format
     *
     * @param  string $format
     * @return string
     */
    public static function toJsFormat($format)
    {
        return str_replace(array("d", "j", "z", "z", "l", "m", "n", "F", "Y"), array("dd", "d", "oo", "o", "DD", "mm", "m", "MM", "yy"), $format);
    }

    /**
     * Sets the default server timezone
     *
     * @param \DateTimeZone|null $timezone
     */
    public static function setServerTimezone(\DateTimeZone $timezone = null)
    {
        self::$serverTimezone = $timezone;
    }

    /**
     * Gets the default server timezone
     *
     * @return \DateTimeZone
     */
    public static function getServerTimezone()
    {
        if (!self::$serverTimezone) {
            self::$serverTimezone = new \DateTimeZone(date_default_timezone_get());
        }

        return self::$serverTimezone;
    }

    /**
     * Sets the user's local timezone
     *
     * @param \DateTimeZone|null $timezone
     */
    public static function setUserTimezone(\DateTimeZone $timezone = null)
    {
        self::$localTimezone = $timezone;
    }

    /**
     * Gets the user's local timezone
     *
     * @return \DateTimeZone
     */
    public static function getUserTimezone()
    {
        if (!self::$localTimezone) {
            self::$localTimezone = new \DateTimeZone(date_default_timezone_get());
        }

        return self::$localTimezone;
    }

    /**
     * Sets the default output format
     *
     * @param string $format
     */
    public static function setDefaultFormat($format)
    {
        self::$defaultFormat = $format;
    }

    /**
     * Gets the default output format
     *
     * @return string
     */
    public static function getDefaultFormat()
    {
        return self::$defaultFormat;
    }

    /**
     * Constructor
     *
     * @param string             $time
     * @param \DateTimeZone|null $timezone
     */
    public function __construct($time = 'now', DateTimeZone $timezone = null)
    {
        if (null === $timezone) {
            $timezone = self::getServerTimezone();
        }

        parent::__construct($time, $timezone);
    }

    /**
     * Returns the DateTime in the user's timezone, using the configured default format
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toUserTime()->format(self::$defaultFormat);
    }

    /**
     * Converts the internal timestamp to the server's local time
     *
     * @return \Orkestra\Common\Type\DateTime
     */
    public function toServerTime()
    {
        return $this->setTimezone(self::$serverTimezone);
    }

    /**
     * Converts the internal timestamp to the user's local time
     *
     * @return \Orkestra\Common\Type\DateTime
     */
    public function toUserTime()
    {
        return $this->setTimezone(self::$localTimezone);
    }
}
