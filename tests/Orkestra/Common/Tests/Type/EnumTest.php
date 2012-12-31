<?php

/*
 * Copyright (c) 2012 Orkestra Community
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
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
