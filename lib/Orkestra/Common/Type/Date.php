<?php

namespace Orkestra\Common\Type;

use Orkestra\Common\Exception\TypeException;

/**
 * Date
 *
 * Extends PHP's native DateTime class to allow representation of Date only values
 */
class Date extends \DateTime
{
    /**
     * @var string $defaultFormat The default format
     */
    private static $defaultFormat;

    /**
     * @return Orkestra\Common\Type\DateTim
     */
    public static function createFromFormat($format, $time, $timezone = null)
    {
        $parent = parent::createFromFormat($format, $time);

        if (empty($parent)) {
            throw new TypeException('Could not create Date from the given format');
        }

        $timestamp = $parent->getTimestamp();
        $date = new self();
        $date->setTimestamp($timestamp);

        return $date;
    }

    /**
     * Create From Default Format
     *
     * Attempts to create a new Date object using a given date value and the configured default
     * date format
     *
     * @var string $date A formatted date string
     * @return Orkestra\Common\Type\Date
     */
    public static function createFromDefaultFormat($date)
    {
        $parent = parent::createFromFormat(self::$defaultFormat, $date);

        if (empty($parent)) {
            throw new TypeException('Could not create Date from the given format');
        }

        $timestamp = $parent->getTimestamp();
        $date = new self();
        $date->setTimestamp($timestamp);

        return $date;
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
     * To String
     *
     * @return string
     */
    public function __toString()
    {
        return $this->format(self::$defaultFormat);
    }
}
