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
    public function __construct() {
        parent::__construct();
    }

    /**
     * To String
     *
     * @return string
     */
    public function __toString()
    {
        return "Never";
    }

    /**
     * Overridden to disallow modification of a NullDateTime
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
     * @return null
     */
    public function diff($datetime2, $absolute = false)
    {
        return null;
    }

    /**
     * Overridden to return only null
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
     * @return \Orkestra\Common\Type\NullDateTime
     */
    public function modify($modify)
    {
        return $this;
    }

    /**
     * Overridden to disallow modification of a NullDateTime
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
     * @return \Orkestra\Common\Type\NullDateTime
     */
    public function setISODate($year, $month, $day = 1)
    {
        return $this;
    }

    /**
     * Overridden to disallow modification of a NullDateTime
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
     * @return \Orkestra\Common\Type\NullDateTime
     */
    public function setTimestamp($unixtimestamp)
    {
        return $this;
    }

    /**
     * Overridden to disallow modification of a NullDateTime
     *
     * @return \Orkestra\Common\Type\NullDateTime
     */
    public function sub($interval)
    {
        return $this;
    }
}
