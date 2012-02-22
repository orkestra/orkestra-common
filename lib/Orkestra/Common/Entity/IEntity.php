<?php

namespace Orkestra\Common\Entity;

/**
 * Entity Interface
 *
 * Defines the contract any entity must follow
 */
interface IEntity { 
    /**
     * Validate
     *
     * Validates the entity, throwing an exception if any invalid fields are found
     */
    public function validate();
    
    /**
     * Add Listener
     *
     * Registers a callback to listen for an event to fire
     *
     * @param string $event The name of the event
     * @param callback $callback A valid callback
     */
    public function addListener($event, $callback);
    
    /**
     * Get Listeners
     *
     * Gets an array of listeners for a specified event
     *
     * @param string $event The name of the event
     * @return array An array of listeners
     */
    public function getListeners($event);
}