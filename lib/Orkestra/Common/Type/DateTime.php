<?php

namespace Orkestra\Common\Type;

use Orkestra\Common\Exception\TypeException;
use DateTimeZone;

/**
 * DateTime
 *
 * Extends PHP's native DateTime to allow automatic conversion to and from user/server time
 */
class DateTime extends \DateTime
{
    /**
     * @var boolean $isServerTime True if the current timestamp is in the server's timezone
     */
    protected $isServerTime = true;

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
     * @param string $format
     * @param string $time
     * @param null $timezone
     *
     * @throws \Orkestra\Common\Exception\TypeException
     * @return \Orkestra\Common\Type\DateTime
     */
    public static function createFromFormat($format, $time, $timezone = null)
    {
        $parent = parent::createFromFormat($format, $time, self::$serverTimezone);

        if (empty($parent)) {
            throw new TypeException('Could not create DateTime from the given format');
        }

        $timestamp = $parent->getTimestamp();
        $dateTime = new self(null, self::$serverTimezone);
        $dateTime->setTimestamp($timestamp);

        return $dateTime;
    }

    /**
     * Create From Default Format
     *
     * Attempts to create a new DateTime object using a given date value and the configured default
     * datetime format
     *
     * @var string $date A formatted datetime string
     *
     * @return Orkestra\Common\Type\DateTime
     */
    public static function createFromDefaultFormat($datetime)
    {
        return self::createFromFormat(self::$defaultFormat, $datetime);
    }

    /**
     * Converts a PHP format string to Javascript format
     *
     * @param string $format
     * @return string
     */
    public static function toJsFormat($format)
    {
        return str_replace(array("d", "j", "z", "z", "l", "m", "n", "F", "Y"), array("dd", "d", "oo", "o", "DD", "mm", "m", "MM", "yy"), $format);
    }

    /**
     * Sets the default server timezone
     *
     * @param DateTimeZone $timezone
     */
    public static function setServerTimezone(\DateTimeZone $timezone)
    {
        self::$serverTimezone = $timezone;
    }

    /**
     * Gets the default server timezone
     *
     * @return DateTimeZone
     */
    public static function getServerTimezone()
    {
        return self::$serverTimezone;
    }

    /**
     * Sets the user's local timezone
     *
     * @param DateTimeZone $timezone
     */
    public static function setUserTimezone(\DateTimeZone $timezone)
    {
        self::$localTimezone = $timezone;
    }

    /**
     * Gets the user's local timezone
     *
     * @return DateTimeZone
     */
    public static function getUserTimezone()
    {
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
     * @param string $time
     * @param DateTimeZone|null $timezone
     */
    public function __construct($time = 'now', DateTimeZone $timezone = null)
    {
        if (null === $timezone) {
            $timezone = self::$serverTimezone;
        }

        parent::__construct($time, $timezone);
    }


    /**
     * To String
     *
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
        if (!$this->isServerTime) {
            $this->setTimezone(self::$serverTimezone);
            $this->isServerTime = true;
        }

        return $this;
    }

    /**
     * Converts the internal timestamp to the user's local time
     *
     * @return \Orkestra\Common\Type\DateTime
     */
    public function toUserTime()
    {
        if ($this->isServerTime) {
            $this->setTimezone(self::$localTimezone);
            $this->isServerTime = false;
        }

        return $this;
    }
}
