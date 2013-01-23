<?php

/*
 * This file is part of the Orkestra Common package.
 *
 * Copyright (c) Orkestra Community
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Orkestra\Common\Entity;

use Doctrine\ORM\Mapping as ORM;
use Orkestra\Common\Type\DateTime;
use Orkestra\Common\Type\NullDateTime;

/**
 * Base class for any entity
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class AbstractEntity
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
     * @var \DateTime $dateModified
     *
     * @ORM\Column(name="date_modified", type="datetime", nullable=true)
     */
    protected $dateModified;

    /**
     * @var \DateTime $dateCreated
     *
     * @ORM\Column(name="date_created", type="datetime")
     */
    protected $dateCreated;

    /**
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
     * @return \DateTime
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
     * @return \DateTime
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
}
