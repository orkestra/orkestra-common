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
 * Enum
 *
 * Base class for any enumeration
 */
abstract class Enum
{
    /**
     * @var array An array containing all possible values for all enums that exist during the execution of this script
     */
    protected static $values;

    /**
     * @var mixed This instance's value
     */
    protected $value;

    /**
     * Constructor
     *
     * @param mixed $value A valid value
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($value)
    {
        $className = get_class($this);

        if (empty(static::$values[$className])) {
            $refl = new \ReflectionClass($className);
            static::$values[$className] = array_values($refl->getConstants());
        }

        if (!in_array($value, static::$values[$className])) {
            throw new \InvalidArgumentException(sprintf('Invalid value specified for enum %s: %s', $className, $value));
        }

        $this->value = $value;
    }

    /**
     * To String
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getValue();
    }

    /**
     * Get Value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
