<?php

namespace Orkestra\Common\Subscriber;

use Doctrine\Common\EventSubscriber,
    Doctrine\ORM\Event\LifecycleEventArgs,
    Doctrine\ORM\Events;
    
use Orkestra\Common\Entity\IEntity;

/**
 * Lifecycle Event Subscriber
 *
 * Provides a mechanism for hooking into an entity's lifecycle
 */
class LifecycleEventSubscriber implements EventSubscriber
{
    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::preRemove,
            Events::postRemove,
            Events::prePersist,
            Events::postPersist,
            Events::preUpdate,
            Events::postUpdate,
            Events::postLoad,
        );
    }
    
    /**
     * Pre Remove
     *
     * @param Doctrine\ORM\Event\LifecycleEventArgs $eventArgs
     */
    public function preRemove(LifecycleEventArgs $eventArgs)
    {
        $this->_executeListeners(Events::preRemove, $eventArgs);
    }
    
    /**
     * Post Remove
     *
     * @param Doctrine\ORM\Event\LifecycleEventArgs $eventArgs
     */
    public function postRemove(LifecycleEventArgs $eventArgs)
    {
        $this->_executeListeners(Events::postRemove, $eventArgs);
    }
    
    /**
     * Pre Persist
     *
     * @param Doctrine\ORM\Event\LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $this->_executeListeners(Events::prePersist, $eventArgs);
    }
    
    /**
     * Post Persist
     *
     * @param Doctrine\ORM\Event\LifecycleEventArgs $eventArgs
     */
    public function postPersist(LifecycleEventArgs $eventArgs)
    {
        $this->_executeListeners(Events::postPersist, $eventArgs);
    }
    
    /**
     * Pre Update
     *
     * @param Doctrine\ORM\Event\LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $this->_executeListeners(Events::preUpdate, $eventArgs);
    }
    
    /**
     * Post Update
     *
     * @param Doctrine\ORM\Event\LifecycleEventArgs $eventArgs
     */
    public function postUpdate(LifecycleEventArgs $eventArgs)
    {
        $this->_executeListeners(Events::postUpdate, $eventArgs);
    }
    
    /**
     * Post Load
     *
     * @param Doctrine\ORM\Event\LifecycleEventArgs $eventArgs
     */
    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $this->_executeListeners(Events::postLoad, $eventArgs);
    }
    
    /**
     * Execute Listeners
     *
     * If the event's associated entity is an IEntity, this method will retrieve
     * any registered listeners for the event and execute them.
     *
     * @param string $event The name of the event
     * @param Doctrine\ORM\Event\LifecycleEventArgs $eventArgs
     */
    protected function _executeListeners($event, LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        
        if ($entity instanceof IEntity) {
            $listeners = $entity->getListeners($event);
        
            foreach ($listeners as $listener) {
                call_user_func($listener, $eventArgs);
            }
        }
    }
}