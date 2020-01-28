<?php

namespace BristolSU\ControlDB\AdditionalProperties;

/**
 * Handles storing the additional properties models can define
 */
interface AdditionalPropertyStore
{

    /**
     * Add a property to a model.
     * 
     * Properties must be initialised before they can be used.
     * 
     * @param string $model Model class name to add the property to
     * @param string $key Key of the property
     * @return void
     */
    public function addProperty(string $model, string $key): void;

    /**
     * Does the given model have any properties
     * 
     * @param string $model Full class name of the model
     * @return bool If the model has properties
     */
    public function hasProperties(string $model): bool;

    /**
     * Get all properties a model has
     * 
     * @param string $model Full class name of the model
     * @return array Array of property keys.
     */
    public function getProperties(string $model): array;
    
}