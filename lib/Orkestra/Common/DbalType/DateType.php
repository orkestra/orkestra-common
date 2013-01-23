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

use Doctrine\DBAL\Types\DateType as DateTypeBase,
    Doctrine\DBAL\Platforms\AbstractPlatform,
    Doctrine\DBAL\Types\ConversionException;

use Orkestra\Common\Type\Date,
    Orkestra\Common\Type\DateTime,
    Orkestra\Common\Type\NullDateTime;

/**
 * Date Type
 *
 * Provides Doctrine DBAL support for Orkestra's custom Date implementation
 */
class DateType extends DateTypeBase
{
    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof NullDateTime || $value === null) {
            return null;
        }

        return $value->format($platform->getDateFormatString());
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return new NullDateTime();
        }

        $val = Date::createFromFormat('!'.$platform->getDateFormatString(), $value);
        if (!$val) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), $platform->getDateFormatString());
        }

        return $val;
    }
}
