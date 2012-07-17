<?php

namespace Orkestra\Common\Tests\Subscriber;

use Doctrine\ORM\Events,
    Doctrine\ORM\Event\LifecycleEventArgs;

use Orkestra\Common\Entity\EntityBase,
    Orkestra\Common\Subscriber\LifecycleEventSubscriber;

/**
 * Tests the LifecycleEventSubscriber
 *
 * @group orkestra
 * @group common
 */
class LifecycleEventSubscriberTest extends \PHPUnit_Framework_TestCase
{
    public function testPrePersist()
    {
        $subscriber = new LifecycleEventSubscriber();

        $listener = function($args) {
            $entity = $args->getEntity();
            $entity->testMethod();
        };

        $entity = new TestEntity();
        $entity->addListener(Events::prePersist, $listener);

        $args = new LifecycleEventArgs($entity, $this->getMock('Doctrine\ORM\EntityManager', array(), array(), '', false));

        $subscriber->prePersist($args);

        $this->assertTrue($entity->called);
    }
}

class TestEntity extends EntityBase
{
    public $called = false;

    public function testMethod()
    {
        $this->called = true;
    }
}
