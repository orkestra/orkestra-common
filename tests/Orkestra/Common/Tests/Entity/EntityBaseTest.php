<?php

namespace Orkestra\Common\Tests\Entity;

use Orkestra\Common\Entity\EntityBase,
    Orkestra\Common\Type\DateTime;

/**
 * EntityBase Test
 *
 * Tests the functionality provided by the EntityBase
 */
class EntityBaseTest extends \PHPUnit_Framework_TestCase
{
    public function testPrePersistSetsDateCreated()
    {
        $entity = $this->getMockForAbstractClass('Orkestra\Common\Entity\EntityBase');

        $this->assertInstanceOf('Orkestra\Common\Type\NullDateTime', $entity->getDateCreated());

        $entity->prePersist();

        $this->assertInstanceOf('Orkestra\Common\Type\DateTime', $entity->getDateCreated());
    }

    public function testPreUpdateSetsDateModified()
    {
        $entity = $this->getMockForAbstractClass('Orkestra\Common\Entity\EntityBase');

        $this->assertInstanceOf('Orkestra\Common\Type\NullDateTime', $entity->getDateModified());

        $entity->preUpdate();

        $this->assertInstanceOf('Orkestra\Common\Type\DateTime', $entity->getDateModified());
    }

    public function testToString()
    {
        $entity = $this->getMockForAbstractClass('Orkestra\Common\Entity\EntityBase');

        $signature = get_class($entity) . ':' . spl_object_hash($entity);

        $this->assertEquals($signature, $entity->__toString());
    }
}
