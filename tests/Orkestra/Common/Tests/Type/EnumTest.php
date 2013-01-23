<?php

/*
 * This file is part of the Orkestra Common package.
 *
 * Copyright (c) Orkestra Community
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Orkestra\Common\Tests\Type;

use Orkestra\Common\Type\Enum;

/**
 * Enum Test
 *
 * Tests the functionality provided by the Enum class
 *
 * @group orkestra
 * @group common
 */
class EnumTest extends \PHPUnit_Framework_TestCase
{
    public function testValidValue()
    {
        $enum = new TestEnum(TestEnum::Value);

        $this->assertEquals('Value', $enum->getValue());
        $this->assertEquals('Value', $enum->__toString());
    }

    public function testInvalidValue()
    {
        $this->setExpectedException('InvalidArgumentException', 'Invalid value specified for enum Orkestra\Common\Tests\Type\TestEnum: Invalid Value');

        $enum = new TestEnum('Invalid Value');
    }
}

class TestEnum extends Enum
{
    const Value = 'Value';
}
