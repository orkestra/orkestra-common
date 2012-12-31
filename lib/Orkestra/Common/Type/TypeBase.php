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
 * Type Base
 *
 * Base class for reference types that wrap or represent a primitive value type.
 */
abstract class TypeBase
{
    /**
     * @var mixed The underlying value of this type
     */
    protected $value;

    /**
     * Constructor
     *
     * @param mixed $value A valid value
     */
    public function __construct($value)
    {
        $this->setValue($value);
    }

    /**
     * Sets the value if it is valid
     *
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     * @return void
     */
    protected function setValue($value)
    {
        if (!$this->validate($value)) {
            throw new \InvalidArgumentException(sprintf('%s is not a valid value', $value));
        }

        $this->value = $value;
    }

    /**
     * Validates a given value and returns true or false based on the result
     *
     * @param  mixed   $value
     * @return boolean True if the value is valid
     */
    abstract protected function validate($value);
}
