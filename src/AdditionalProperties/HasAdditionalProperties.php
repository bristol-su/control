<?php

namespace BristolSU\ControlDB\AdditionalProperties;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Allow a model to have any arbitrary properties, set at runtime
 */
trait HasAdditionalProperties
{

    /**
     * Holds the additional properties for the model
     * 
     * @var array
     */
    private $additionalProperties;

    /**
     * Initialise the trait
     *
     * - Add all additional properties to the appends array
     * - Add additional_properties column to hidden
     * - Cast the additional_properties column to an array
     */
    public function initializeHasAdditionalProperties()
    {
        $this->additionalProperties = (app(AdditionalPropertyStore::class)->getProperties(static::class) ?? []);
        if (is_subclass_of($this, Model::class)) {
            $this->append($this->additionalProperties);
            $this->addHidden($this->getColumnName());
            $this->casts[] = $this->getColumnName();
        } else {
            throw new Exception('The HasAdditionalProperties trait must only be used in an Eloquent model');
        }
    }

    /**
     * Add an additional property
     *
     * @param $key
     */
    public static function addProperty(string $key): void
    {
        app(AdditionalPropertyStore::class)->addProperty(static::class, $key);
    }

    /**
     * Retrieve an additional attribute value
     * 
     * @param string $key Key of the attribute
     * @return mixed Value of the attribute
     */
    public function getAdditionalAttribute(string $key)
    {
        return (array_key_exists($key, $this->{$this->getColumnName()}) 
            ? $this->{$this->getColumnName()}[$key] : null);
    }

    /**
     * Set an additional attribute value
     * 
     * @param string $key Key of the attribute
     * @param mixed $value Value of the attribute
     */
    public function setAdditionalAttribute(string $key, $value)
    {
        $this->attributes[$this->getColumnName()] = array_merge($this->{$this->getColumnName()}, [$key => $value]);
    }

    /**
     * Override the default getAttribute function
     * 
     * Any time an attribute is retrieved, we will check if it's an additional property and return it if so
     * 
     * @param string $key Key of the property to retrieve
     * @return mixed Value of the property
     */
    public function getAttribute($key)
    {
        if (in_array($key, $this->additionalProperties)) {
            return $this->getAdditionalAttribute($key);
        }
        return parent::getAttribute($key);
    }

    /**
     * Override the default getAttribute function
     *
     * Any time an attribute is set, we will check if it's an additional property and set it correspondingly if so
     *
     * @param string $key Key of the property to retrieve
     * @param mixed $value Value of the attribute
     * @return mixed Value of the property
     */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->additionalProperties)) {
            $this->setAdditionalAttribute($key, $value);
        } else {
            parent::setAttribute($key, $value);
        }
    }

    /**
     * Cast the additional attributes column to an array, or return an empty array by default.
     * 
     * @return array|mixed
     */
    public function getAdditionalAttributesAttribute()
    {
        if(!array_key_exists($this->getColumnName(), $this->attributes)) {
            return [];
        }
        if(is_string($this->attributes[$this->getColumnName()])) {
            return (json_decode($this->attributes[$this->getColumnName()], true) ?? []);
        }
        return $this->attributes[$this->getColumnName()];
    }

    /**
     * Get the name of the additional attributes column
     * 
     * @return string Name of the additional attributes column
     */
    private function getColumnName()
    {
        return 'additional_attributes';
    }

    /**
     * Dynamically define accessors for the appended properties.
     * 
     * By catching all method calls, we can check if they are calls for an accessor or mutator to an attribute and
     * carry out the corresponding action.
     * 
     * @param string $method Method of the call
     * @param array $args Arguments for the call
     * @return mixed
     */
    public function __call($method, $args)
    {
        // Check if the call was an accessor
        $additionalAccessors = array_map(function($propertyKey) {
            return 'get'.Str::studly($propertyKey).'Attribute';
        }, $this->additionalProperties);
        if(in_array($method, $additionalAccessors)) {
            return $this->getAdditionalAttribute(
                Str::snake(Str::substr(Str::substr($method, 3), 0, -9))
            );
        }
        
        // Check if the call was a mutator
        $additionalAccessors = array_map(function($propertyKey) {
            return 'set'.Str::studly($propertyKey).'Attribute';
        }, $this->additionalProperties);
        if(in_array($method, $additionalAccessors)) {
            $this->setAdditionalAttribute(
                Str::snake(Str::substr(Str::substr($method, 3), 0, -9)), $args[0]
            );
        } else {
            return parent::__call($method,
                $args);
        }
        
        
    }
}