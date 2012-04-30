<?php

namespace Orkestra\Common\Entity;

/**
 * Defines the contract for entities with encrypted properties to follow
 */
interface IEntityWithEncryptedProperties
{
    /**
     * Gets an array of properties that should be encrypted prior
     * to being persisted.
     *
     * @return array An array of properties that should be encrypted
     */
    public function getEncryptedProperties();
}