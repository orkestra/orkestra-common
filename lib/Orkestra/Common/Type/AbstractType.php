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

/**
 * Type Base
 *
 * Base class for reference types that wrap or represent a primitive value type.
 */
abstract class AbstractType
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
     * @param mixed $value
     *
     * @return boolean True if the value is valid
     */
    abstract protected function validate($value);
}
