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
     * @var array An array containing all possible values for all enums that exist during the execution of this script
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
        $className = get_class($this);
        
        if (empty(static::$_values[$className])) {
            $refl = new \ReflectionClass($className);
            static::$_values[$className] = array_values($refl->getConstants());
        }

        if (!in_array($value, static::$_values[$className])) {
            throw new \InvalidArgumentException(sprintf('Invalid value specified for enum %s: %s', $className, $value));
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
