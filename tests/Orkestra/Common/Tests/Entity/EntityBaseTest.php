<?php

namespace Orkestra\Common\Tests\Entity;

require __DIR__ . '/../../../../bootstrap.php';

use Orkestra\Common\Tests\TestCase,
    Orkestra\Common\Entity\EntityBase,
	Orkestra\Common\Type\DateTime;

/**
 * EntityBase Test
 *
 * Tests the functionality provided by the EntityBase
 */
class EntityBaseTest extends TestCase
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
    
	public function testSettersAndGetters()
    {
        $entity = $this->getMockForAbstractClass('Orkestra\Common\Entity\EntityBase');
                
        $signature = get_class($entity) . ':' . spl_object_hash($entity);
                
        $this->setProperty($entity, 'id', 5);
        $this->assertEquals(5, $entity->getId());
		
		$dateCreated = new DateTime();
		$this->setProperty($entity, 'dateCreated', $dateCreated);
		$this->assertSame($dateCreated, $entity->getDateCreated());
		
		$dateModified = new DateTime();
		$this->setProperty($entity, 'dateModified', $dateModified);
		$this->assertSame($dateModified, $entity->getDateModified());
                
        $entity->setActive(true);
        $this->assertEquals(true, $entity->getActive());
        
		$this->assertEquals($signature, $entity->__toString());
    }
}