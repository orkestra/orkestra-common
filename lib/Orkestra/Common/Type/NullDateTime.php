<?php

/*
 * Copyright (c) 2012 Orkestra Community
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */

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
