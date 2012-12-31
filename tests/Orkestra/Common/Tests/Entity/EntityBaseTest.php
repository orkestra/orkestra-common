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

namespace Orkestra\Common\Tests\Entity;

use Orkestra\Common\Entity\AbstractEntity,
    Orkestra\Common\Type\DateTime;

/**
 * AbstractEntity Test
 *
 * Tests the functionality provided by the AbstractEntity
 */
class EntityBaseTest extends \PHPUnit_Framework_TestCase
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
