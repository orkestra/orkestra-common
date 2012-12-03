<?php

namespace Orkestra\Common\DBAL\Types;

use Doctrine\DBAL\Types\TimeType as TimeTypeBase,
    Doctrine\DBAL\Platforms\AbstractPlatform,
    Doctrine\DBAL\Types\ConversionException;

use Orkestra\Common\Type\DateTime,
    Orkestra\Common\Type\NullDateTime;

/**
 * Time Type
 *
 * Provides Doctrine DBAL support for Orkestra's custom DateTime implementation
 */
class TimeType extends TimeTypeBase
{
    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof NullDateTime || $value === null) {
            return null;
        }
        else if (!$value instanceof DateTime) {
            return $value->format($platform->getTimeFormatString());
        }

        return $value->toServerTime()->format($platform->getTimeFormatString());
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return new NullDateTime();
        }

        $val = DateTime::createFromFormat($platform->getTimeFormatString(), $value);
        if (!$val) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), $platform->getTimeFormatString());
        }

        return $val;
    }
}
