<?php

namespace Orkestra\Common\Type;

/**
 * Null Date Time
 *
 * Type to represent a null value Date or DateTime field
 */
class NullDateTime extends DateTime
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "Never";
    }

    /**
     * Overridden to disallow modification of a NullDateTime
     *
     * @param \DateInterval $interval
     *
     * @return \Orkestra\Common\Type\NullDateTime
     */
    public function add($interval)
    {
        return $this;
    }

    /**
     * Overridden to disallow comparisons with a NullDateTime
     *
     * @param \DateTime $datetime2
     * @param bool $absolute
     *
     * @return null
     */
    public function diff($datetime2, $absolute = false)
    {
        return null;
    }

    /**
     * Overridden to return only null
     *
     * @param string $format
     *
     * @return null
     */
    public function format($format)
    {
        return null;
    }

    /**
     * Overridden to return only null
     *
     * @return null
     */
    public function getOffset()
    {
        return null;
    }

    /**
     * Overridden to return only null
     *
     * @return null
     */
    public function getTimestamp()
    {
        return null;
    }

    /**
     * Overridden to return only null
     *
     * @return null
     */
    public function getTimeZone()
    {
        return DateTime::getServerTimezone();
    }

    /**
     * Overridden to disallow modification of a NullDateTime
     *
     * @param string $modify
     *
     * @return \Orkestra\Common\Type\NullDateTime
     */
    public function modify($modify)
    {
        return $this;
    }

    /**
     * Overridden to disallow modification of a NullDateTime
     *
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return \Orkestra\Common\Type\NullDateTime
     */
    public function setDate($year, $month, $day)
    {
        return $this;
    }

    /**
     * Overridden to disallow modification of a NullDateTime
     *
     * @param int $year
     * @param int $month
     * @param int $day
     *
     * @return \Orkestra\Common\Type\NullDateTime
     */
    public function setISODate($year, $month, $day = 1)
    {
        return $this;
    }

    /**
     * Overridden to disallow modification of a NullDateTime
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     *
     * @return \Orkestra\Common\Type\NullDateTime
     */
    public function setTime($hour, $minute, $second = 0)
    {
        return $this;
    }

    /**
     * Overridden to disallow modification of a NullDateTime
     *
     * @param int $unixtimestamp
     *
     * @return \Orkestra\Common\Type\NullDateTime
     */
    public function setTimestamp($unixtimestamp)
    {
        return $this;
    }

    /**
     * Overridden to disallow modification of a NullDateTime
     *
     * @param \DateInterval $interval
     *
     * @return \Orkestra\Common\Type\NullDateTime
     */
    public function sub($interval)
    {
        return $this;
    }
}
