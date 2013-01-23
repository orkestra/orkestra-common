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

use Doctrine\DBAL\Types\DateTimeType as DateTimeTypeBase,
    Doctrine\DBAL\Platforms\AbstractPlatform,
    Doctrine\DBAL\Types\ConversionException;

use Orkestra\Common\Type\DateTime,
    Orkestra\Common\Type\NullDateTime;

/**
 * Date Time Type
 *
 * Provides Doctrine DBAL support for Orkestra's custom DateTime and NullDateTime implementations
 */
class DateTimeType extends DateTimeTypeBase
{
    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof NullDateTime || $value === null) {
            return null;
        } elseif (!$value instanceof DateTime) {
            return $value->format($platform->getDateTimeFormatString());
        }

        return $value->toServerTime()->format($platform->getDateTimeFormatString());
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return new NullDateTime();
        }

        $val = DateTime::createFromFormat($platform->getDateTimeFormatString(), $value);
        if (!$val) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), $platform->getDateTimeFormatString());
        }

        return $val;
    }
}
