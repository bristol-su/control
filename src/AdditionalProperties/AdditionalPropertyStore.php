<?php

namespace BristolSU\ControlDB\AdditionalProperties;

interface AdditionalPropertyStore
{

    public function addProperty(string $model, string $key);

    public function hasProperties(string $model);

    public function getProperties(string $model);
    
}