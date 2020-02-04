<?php

namespace BristolSU\ControlDB\AdditionalProperties;

/**
 * Handles additional properties
 */
interface ImplementsAdditionalProperties
{

    /**
     * Add an additional property
     *
     * @param $key
     */
    public static function addProperty(string $key): void;

    /**
     * Get all additional attributes the model is using
     *
     * @return array
     */
    public static function getAdditionalAttributes(): array;
    
    /**
     * Retrieve an additional attribute value
     *
     * @param string $key Key of the attribute
     * @return mixed Value of the attribute
     */
    public function getAdditionalAttribute(string $key);

    /**
     * Set an additional attribute value
     *
     * @param string $key Key of the attribute
     * @param mixed $value Value of the attribute
     */
    public function setAdditionalAttribute(string $key, $value);

    /**
     * Save an additional attribute value
     *
     * @param string $key Key of the attribute
     * @param mixed $value Value of the attribute
     */
    public function saveAdditionalAttribute(string $key, $value);

}