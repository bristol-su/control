<?php

namespace BristolSU\ControlDB\AdditionalProperties;

/**
 * Handles storing the additional properties models can define using a local array
 */
class AdditionalPropertySingletonStore implements AdditionalPropertyStore
{

    /**
     * Properties that can be used
     * 
     * Stores with the model as the key, then an array of property keys
     * 
     * @var array [ 'ModelClassName' => ['student_id', 'faculty']
     */
    private $properties = [];

    /**
     * Add a property to a model.
     *
     * Properties must be initialised before they can be used.
     *
     * @param string $model Model class name to add the property to
     * @param string $key Key of the property
     * @return void
     */
    public function addProperty(string $model, string $key): void {
        if(!$this->hasProperties($model)) {
            $this->properties[$model] = [];
        }
        $this->properties[$model][] = $key;
    }

    /**
     * Does the given model have any properties
     *
     * @param string $model Full class name of the model
     * @return bool If the model has properties
     */
    public function hasProperties(string $model): bool
    {
        return array_key_exists($model, $this->properties);
    }

    /**
     * Get all properties a model has
     *
     * @param string $model Full class name of the model
     * @return array Array of property keys.
     */
    public function getProperties(string $model): array
    {
        if($this->hasProperties($model)) {
            return $this->properties[$model];
        }
        return [];
    }
    
}