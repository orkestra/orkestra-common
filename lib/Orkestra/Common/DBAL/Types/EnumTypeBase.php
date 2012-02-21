<?php

namespace Orkestra\Common\DBAL\Types;

use Doctrine\DBAL\Types\StringType,
    Doctrine\DBAL\Platforms\AbstractPlatform,
    Doctrine\DBAL\Types\ConversionException;

/**
 * Base class for enumeration types
 *
 * Adds support for Enums in Doctrine's DBAL. Extend this class
 * and specify the $_name and $_class properties, then register
 * your new type with Doctrine\DBAL\Types\Type
 */
abstract class EnumTypeBase extends StringType
{
    /**
     * @var string A unique name for this enum type
     */
    protected $_name;
    
    /**
     * @var string The fully qualified class name of the Enum that this class wraps
     */
    protected $_class;

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $class = $this->_class;
        
        try {
            $value = new $class($value);
        }
        catch (\InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, $this->getName());
        }
        
        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string)$value;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->_name;
    }
}