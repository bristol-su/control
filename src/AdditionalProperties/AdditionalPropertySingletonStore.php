<?php

namespace BristolSU\ControlDB\AdditionalProperties;

class AdditionalPropertySingletonStore implements AdditionalPropertyStore
{

    private $properties = [];
    
    public function addProperty(string $model, string $key) {
        if(!$this->hasProperties($model)) {
            $this->properties[$model] = [];
        }
        $this->properties[$model][] = $key;
    }

    public function hasProperties(string $model)
    {
        return array_key_exists($model, $this->properties);
    }
    
    public function getProperties(string $model)
    {
        if($this->hasProperties($model)) {
            return $this->properties[$model];
        }
        return [];
    }
    
}