<?php

namespace Orkestra\Common\Tests\DBAL\Types;

use Orkestra\Common\Tests\TestCase;

require_once __DIR__ . '/../../TestCase.php';

use Doctrine\DBAL\Types\Type;

/**
 * EncryptedStringType Test
 *
 * Tests the functionality of the EncryptedStringType DBAL type
 *
 * @group orkestra
 * @group common
 * @group crypt
 */
class EncryptedStringTypeTest extends TestCase
{
    protected $_typesMap;

    protected $_type;

    protected $_platform;

    protected function setUp()
    {
        parent::setUp();

        $this->_typesMap = Type::getTypesMap();

        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typeObjects', array());
        Type::addType('encrypted_string', 'Orkestra\Common\DBAL\Types\EncryptedStringType');

        $this->_type = Type::getType('encrypted_string');

        $this->_platform = $this->getMockForAbstractClass('Doctrine\DBAL\Platforms\AbstractPlatform');
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typesMap', $this->_typesMap);
        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typeObjects', array());
    }

    public function testConversion()
    {
        $this->assertInstanceOf('Orkestra\Common\DBAL\Types\EncryptedStringType', $this->_type);

        $this->_type->setKey('key');

        $value = 'This is a test';

        $encryptedValue = $this->_type->convertToDatabaseValue($value, $this->_platform);

        $decryptedValue = $this->_type->convertToPHPValue($encryptedValue, $this->_platform);

        $this->assertEquals($value, $decryptedValue);
    }
}
