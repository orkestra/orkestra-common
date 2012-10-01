<?php

namespace Orkestra\Common\Entity;

use Doctrine\ORM\Mapping as ORM;

use Orkestra\Common\Type\DateTime,
    Orkestra\Common\Type\NullDateTime;

/**
 * Entity Base
 *
 * Base class for all entities
 *
 * @ORM\MappedSuperClass
 * @ORM\HasLifecycleCallbacks
 */
abstract class EntityBase implements IEntity
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var boolean $active
     *
     * @ORM\Column(name="active", type="boolean")
     */
    protected $active = true;

    /**
     * @var Orkestra\Common\Type\DateTime $dateModified
     *
     * @ORM\Column(name="date_modified", type="datetime", nullable=true)
     */
    protected $dateModified;

    /**
     * @var Orkestra\Common\Type\DateTime $dateCreated
     *
     * @ORM\Column(name="date_created", type="datetime")
     */
    protected $dateCreated;

    /**
     * @var array An array of bound event listeners
     */
    protected $_listeners = array();

    /**
     * To String
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s:%s', get_class($this), spl_object_hash($this));
    }

    /**
     * Get ID
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * Set Active
     *
     * @param boolean
     */
    public function setActive($active)
    {
        $this->active = $active ? true : false;
    }

    /**
     * Get Active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Is Active
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->getActive();
    }

    /**
     * Get Date Created
     *
     * @return Orkestra\Common\Type\DateTime
     */
    public function getDateCreated()
    {
        if (empty($this->dateCreated)) {
            $this->dateCreated = new NullDateTime();
        }

        return $this->dateCreated;
    }

    /**
     * Get Date Modified
     *
     * @return Orkestra\Common\Type\DateTime
     */
    public function getDateModified()
    {
        if (empty($this->dateModified)) {
            $this->dateModified = new NullDateTime();
        }

        return $this->dateModified;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->dateCreated = new DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->dateModified = new DateTime();
    }

    /**
     * {@inheritdoc}
     *
     * @ORM\PrePersist
	 * @ORM\PreUpdate
     */
    public function validate()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function addListener($event, $callback)
    {
        $this->_listeners[$event][] = $callback;
    }

    /**
     * {@inheritdoc}
     */
    public function getListeners($event)
    {
        return empty($this->_listeners[$event]) ? array() : $this->_listeners[$event];
    }
}
