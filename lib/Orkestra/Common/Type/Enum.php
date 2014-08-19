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
        if (!in_array($value, static::getValues())) {
            throw new \InvalidArgumentException(sprintf('Invalid value specified for enum %s: %s', get_class($this), $value));
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

    /**
     * @param string $name
     * @param array $args
     *
     * @return static
     */
    public static function __callStatic($name, $args)
    {
        return new static(constant('static::' . $name));
    }

    /**
     * @return array
     */
    public static function toArray()
    {
        return static::getValues();
    }

    /**
     * @return array
     */
    private static function getValues()
    {
        $className = get_called_class();

        if (empty(static::$values[$className])) {
            $refl = new \ReflectionClass($className);
            static::$values[$className] = array_values($refl->getConstants());
        }

        return static::$values[$className];
    }
}
