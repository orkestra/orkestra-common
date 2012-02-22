<?php

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
    protected $_value;
    
    /**
     * Constructor
     *
     * @param mixed $value A valid value
     */
    public function __construct($value)
    {
        $this->_setValue($value);
    }
    
    /**
     * Set Value
     *
     * Sets the value if it is valid
     *
     * @return void
     */
    protected function _setValue($value)
    {
        if (!$this->_validate($value)) {
            throw new \InvalidArgumentException(sprintf('%s is not a valid value', $value));
        }
        
        $this->_value = $value;
    }
    
    /**
     * Validate
     *
     * Validates a given value and returns true or false based on the result
     *
     * @param mixed $value
     * @return boolean True if the value is valid
     */
    abstract protected function _validate($value);
}