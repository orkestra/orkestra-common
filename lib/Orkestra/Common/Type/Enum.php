<?php

namespace Orkestra\Common\Type;

/**
 * Enum
 *
 * Base class for any enumeration
 */
abstract class Enum
{
    /**
     * @var array An array of possible values. This field is filled using Reflection to get the class constants
     */
    protected static $_values;
    
    /**
     * @var mixed This instance's value
     */
    protected $_value;
    
    /**
     * Constructor
     *
     * @param mixed $value A valid value
     */
    public function __construct($value)
    {
        if (empty(static::$_values)) {
            $refl = new \ReflectionClass(get_class($this));
            static::$_values = array_values($refl->getConstants());
        }
        
        if (!in_array($value, static::$_values)) {
            throw new \InvalidArgumentException(sprintf('Invalid value specified for enumeration %s: %s', get_class($this), $value));
        }
        
        $this->_value = $value;
    }
    
    /**
     * To String
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getValue();
    }
    
    /**
     * Get Value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->_value;
    }
}
