<?php

namespace Orkestra\Common\Tests;

/**
 * Base test case class for all test cases.
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $_container;
    
    protected function setUp()
    {
        $this->_createContainer();
    }
    
    /**
     * Creates a new, empty dependency injection container
     */
    protected function _createContainer($new = true)
    {
        if (!$new && !empty($this->_container)) {
            return;
        }
        
        $this->_container = new \Symfony\Component\DependencyInjection\ContainerBuilder();
        \Model\Common\Registry::set('container', $this->_container);
    }
    
    /**
     * Set Property
     *
     * Sets an inaccessible property to a new value
     *
     * @param object $object The object to modify
     * @param string $property The name of the property
     * @param mixed $value The new value of the property
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
     * @param string $class The name of the class to modify
     * @param string $property The name of the property
     * @param mixed $value The new value of the property
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
     * @param object $object The object
     * @param string $method The name of the method to call
     * @param mixed $args The arguments to pass to the method
     * @param string $baseClass If the property is private and exists in a base class, this must be specified with which base class
     */
    public function callMethod($object, $method, $args = array(), $baseClass = null)
    {
        $reflectedClass = new \ReflectionClass((empty($baseClass) ? $object : $baseClass));
        $reflectedMethod = $reflectedClass->getMethod($method);
        $reflectedMethod->setAccessible(true);
        return $reflectedMethod->invokeArgs($object, (array)$args);
    }

    /**
     * Call Static Method
     *
     * Calls an inaccessible static method
     *
     * @param string $class The class name
     * @param string $method The name of the method to call
     * @param mixed $args The arguments to pass to the method
     */
    public function callStaticMethod($class, $method, $args = array())
    {
        $reflectedClass = new \ReflectionClass($class);
        $reflectedMethod = $reflectedClass->getMethod($method);
        $reflectedMethod->setAccessible(true);
        return $reflectedMethod->invokeArgs(null, (array)$args);
    }
}