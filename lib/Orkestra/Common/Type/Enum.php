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
