<?php

namespace Orkestra\Common\Tests\Subscriber;

require __DIR__ . '/../../../../bootstrap.php';

use Orkestra\Common\Tests\TestCase;

use Doctrine\ORM\Events,
    Doctrine\ORM\Event\LifecycleEventArgs;

use Orkestra\Common\Entity\EntityBase,
    Orkestra\Common\Subscriber\EncryptedPropertiesSubscriber,
    Orkestra\Common\Cryptography\Encryptor,
    Orkestra\Common\Entity\IEntityWithEncryptedProperties;

/**
 * Tests the EncryptedPropertiesSubscriber
 *
 * @group orkestra
 * @group common
 */
class EncryptedPropertiesSubscriberTest extends TestCase
{
    public function testSubscriber()
    {
        $encryptor = new Encryptor();
        $subscriber = new EncryptedPropertiesSubscriber($encryptor, 'abc123');

        $entity = new TestEncryptedEntity();
        $entity->property = 'This is a message';

        $args = new LifecycleEventArgs($entity, $this->getMock('Doctrine\ORM\EntityManager', array(), array(), '', false));

        $subscriber->prePersist($args);

        $this->assertNotEquals('This is a message', $entity->property);

        $subscriber->postPersist($args);

        $this->assertEquals('This is a message', $entity->property);
    }
}

class TestEncryptedEntity extends EntityBase implements IEntityWithEncryptedProperties
{
    public $property;

    public function getProperty()
    {
        return $this->property;
    }

    public function setProperty($value)
    {
        $this->property = $value;
    }

    public function getEncryptedProperties()
    {
        return array('property');
    }
}
