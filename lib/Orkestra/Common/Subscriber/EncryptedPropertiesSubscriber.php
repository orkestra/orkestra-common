<?php

namespace Orkestra\Common\Subscriber;

use Doctrine\Common\EventSubscriber,
    Doctrine\ORM\Event\LifecycleEventArgs,
    Doctrine\ORM\Events;
    
use Orkestra\Common\Cryptography\Encryptor,
    Orkestra\Common\Entity\IEntityWithEncryptedProperties;

/**
 * Encrypts and decrypts properties on an Entity
 */
class EncryptedPropertiesSubscriber implements EventSubscriber
{
    /**
     * @var \Orkestra\Common\Cryptography\Encryptor
     */
    protected $_encryptor;

    /**
     * @var string
     */
    protected $_key;

    /**
     * @param \Orkestra\Common\Cryptography\Encryptor $encryptor
     * @param string $key
     */
    public function __construct(Encryptor $encryptor, $key)
    {
        $this->_encryptor = $encryptor;
        $this->_key = $key;
    }

    /**
     * Returns an array of events this subscriber wants to listen to
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(Events::prePersist, Events::postPersist, Events::preUpdate, Events::postUpdate, Events::postLoad);
    }

    /**
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->_encryptProperties($args);
    }

    /**
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->_decryptProperties($args);
    }

    /**
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->_encryptProperties($args);
    }

    /**
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->_decryptProperties($args);
    }

    /**
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $this->_decryptProperties($args);
    }

    /**
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     *
     * @return void
     */
    protected function _encryptProperties(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        
        if (!$entity instanceof IEntityWithEncryptedProperties)
            return;
            
        $properties = $entity->getEncryptedProperties();
        
        foreach ($properties as $property) {
            $value = call_user_func(array($entity, 'get' . $property));
            $iv = $this->_encryptor->createIv();

            $value = $this->_encryptor->encrypt($value, $this->_key, $iv);
            call_user_func(array($entity, 'set' . $property), $iv . '' . $value);
        }
    }

    /**
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     *
     * @return void
     */
    protected function _decryptProperties(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        
        if (!$entity instanceof IEntityWithEncryptedProperties)
            return;
            
        $properties = $entity->getEncryptedProperties();
        
        foreach ($properties as $property) {
            $value = call_user_func(array($entity, 'get' . $property));
            $ivSize = $this->_encryptor->getIvSize();
            $iv = substr($value, 0, $ivSize);
            $value = substr($value, $ivSize);

            $value = $this->_encryptor->decrypt($value, $this->_key, $iv);
            call_user_func(array($entity, 'set' . $property), $value);
        }
    }
}
