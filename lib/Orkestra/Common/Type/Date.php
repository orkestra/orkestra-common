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

use Orkestra\Common\Exception\TypeException;

/**
 * Extends PHP's native DateTime class to allow representation of Date only values
 */
class Date extends \DateTime
{
    /**
     * @var string $defaultFormat The default format
     */
    private static $defaultFormat;

    /**
     * @param string $format
     * @param string $time
     * @param null   $timezone
     *
     * @throws \Orkestra\Common\Exception\TypeException
     * @return \Orkestra\Common\Type\DateTime
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
     *
     * @throws \Orkestra\Common\Exception\TypeException
     * @return \Orkestra\Common\Type\Date
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
     * @return string
     */
    public function __toString()
    {
        return $this->format(self::$defaultFormat);
    }
}
