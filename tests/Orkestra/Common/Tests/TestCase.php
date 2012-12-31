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

namespace Orkestra\Common\Tests;

/**
 * Base test case class for all test cases.
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Set Property
     *
     * Sets an inaccessible property to a new value
     *
     * @param object $object    The object to modify
     * @param string $property  The name of the property
     * @param mixed  $value     The new value of the property
     * @param string $baseClass If the property is private and exists in a base class, this must be specified with which base class
     */
    public function setProperty($object, $property, $value, $baseClass = null)
    {
        $reflectedClass = new \ReflectionClass((empty($baseClass) ? $object : $baseClass));
        $reflectedProperty = $reflectedClass->getProperty($property);
        $reflectedProperty->setAccessible(true);
        $reflectedProperty->setValue($object, $value);
    }

    /**
     * Set Static Property
     *
     * Sets an inaccessible static property to a new value
     *
     * @param string $class    The name of the class to modify
     * @param string $property The name of the property
     * @param mixed  $value    The new value of the property
     */
    public function setStaticProperty($class, $property, $value)
    {
        $reflectedClass = new \ReflectionClass($class);
        $reflectedProperty = $reflectedClass->getProperty($property);
        $reflectedProperty->setAccessible(true);
        $reflectedProperty->setValue($value);
    }

    /**
     * Call Method
     *
     * Calls an inaccessible class method
     *
     * @param object $object    The object
     * @param string $method    The name of the method to call
     * @param mixed  $args      The arguments to pass to the method
     * @param string $baseClass If the property is private and exists in a base class, this must be specified with which base class
     *
     * @return mixed The result of the method call, if any
     */
    public function callMethod($object, $method, $args = array(), $baseClass = null)
    {
        $reflectedClass = new \ReflectionClass((empty($baseClass) ? $object : $baseClass));
        $reflectedMethod = $reflectedClass->getMethod($method);
        $reflectedMethod->setAccessible(true);

        return $reflectedMethod->invokeArgs($object, (array) $args);
    }

    /**
     * Call Static Method
     *
     * Calls an inaccessible static method
     *
     * @param string $class  The class name
     * @param string $method The name of the method to call
     * @param mixed  $args   The arguments to pass to the method
     *
     * @return mixed The result of the method call, if any
     */
    public function callStaticMethod($class, $method, $args = array())
    {
        $reflectedClass = new \ReflectionClass($class);
        $reflectedMethod = $reflectedClass->getMethod($method);
        $reflectedMethod->setAccessible(true);

        return $reflectedMethod->invokeArgs(null, (array) $args);
    }
}
