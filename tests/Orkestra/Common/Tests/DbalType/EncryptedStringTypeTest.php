<?php

namespace Orkestra\Common\Tests\DBAL\Types;

use Orkestra\Common\Tests\TestCase;

require_once __DIR__ . '/../TestCase.php';

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
    protected $typesMap;

    protected $type;

    protected $platform;

    protected function setUp()
    {
        parent::setUp();

        $this->typesMap = Type::getTypesMap();

        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typeObjects', array());
        Type::addType('encrypted_string', 'Orkestra\Common\DbalType\EncryptedStringType');

        $this->type = Type::getType('encrypted_string');

        $this->platform = $this->getMockForAbstractClass('Doctrine\DBAL\Platforms\AbstractPlatform');
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typesMap', $this->typesMap);
        $this->setStaticProperty('Doctrine\DBAL\Types\Type', '_typeObjects', array());
    }

    public function testConversion()
    {
        $this->assertInstanceOf('Orkestra\Common\DbalType\EncryptedStringType', $this->type);

        $this->type->setKey('key');

        $value = 'This is a test';

        $encryptedValue = $this->type->convertToDatabaseValue($value, $this->platform);

        $decryptedValue = $this->type->convertToPHPValue($encryptedValue, $this->platform);

        $this->assertEquals($value, $decryptedValue);
    }
}
