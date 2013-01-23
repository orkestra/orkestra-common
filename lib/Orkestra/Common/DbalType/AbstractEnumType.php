<?php

/*
 * This file is part of the Orkestra Common package.
 *
 * Copyright (c) Orkestra Community
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Orkestra\Common\DbalType;

use Doctrine\DBAL\Types\StringType,
    Doctrine\DBAL\Platforms\AbstractPlatform,
    Doctrine\DBAL\Types\ConversionException;

/**
 * Base class for enumeration types
 *
 * Adds support for Enums in Doctrine's DBAL. Extend this class
 * and specify the $name and $class properties, then register
 * your new type with Doctrine\DBAL\Types\Type
 */
abstract class AbstractEnumType extends StringType
{
    /**
     * @var string A unique name for this enum type
     */
    protected $name;

    /**
     * @var string The fully qualified class name of the Enum that this class wraps
     */
    protected $class;

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $class = $this->class;

        if ($value === null || $value === '') {
            return null;
        }

        try {
            $value = new $class($value);
        } catch (\InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, $this->getName());
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }
}
