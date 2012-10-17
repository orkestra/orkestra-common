<?php

namespace Orkestra\Common\Entity;

/**
 * Defines the contract any entity must follow
 */
interface EntityInterface {
    /**
     * Validates the entity, throwing an exception if any invalid fields are found
     */
    function validate();
}
