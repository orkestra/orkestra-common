<?php

/*
 * This file is part of the Orkestra Common package.
 *
 * Copyright (c) Orkestra Community
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Orkestra\Common\Tests\Entity;

use Orkestra\Common\Entity\AbstractEntity,
    Orkestra\Common\Type\DateTime;

/**
 * AbstractEntity Test
 *
 * Tests the functionality provided by the AbstractEntity
 */
class AbstractEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testPrePersistSetsDateCreated()
    {
        $entity = $this->getMockForAbstractClass('Orkestra\Common\Entity\AbstractEntity');

        $this->assertInstanceOf('Orkestra\Common\Type\NullDateTime', $entity->getDateCreated());

        $entity->prePersist();

        $this->assertInstanceOf('Orkestra\Common\Type\DateTime', $entity->getDateCreated());
    }

    public function testPreUpdateSetsDateModified()
    {
        $entity = $this->getMockForAbstractClass('Orkestra\Common\Entity\AbstractEntity');

        $this->assertInstanceOf('Orkestra\Common\Type\NullDateTime', $entity->getDateModified());

        $entity->preUpdate();

        $this->assertInstanceOf('Orkestra\Common\Type\DateTime', $entity->getDateModified());
    }

    public function testToString()
    {
        $entity = $this->getMockForAbstractClass('Orkestra\Common\Entity\AbstractEntity');

        $signature = get_class($entity) . ':' . spl_object_hash($entity);

        $this->assertEquals($signature, $entity->__toString());
    }
}
