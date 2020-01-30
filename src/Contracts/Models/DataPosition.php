<?php

namespace BristolSU\ControlDB\Contracts\Models;

use BristolSU\ControlDB\AdditionalProperties\ImplementsAdditionalProperties;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * Handles attributes about a position
 */
interface DataPosition extends ImplementsAdditionalProperties, Arrayable, Jsonable
{
    /**
     * Get the ID of a position
     * 
     * @return int
     */
    public function id(): int;

    /**
     * Get the name of the position
     * 
     * @return string|null
     */
    public function name(): ?string;

    /**
     * Get a description for the position
     * 
     * @return string|null
     */
    public function description(): ?string;

    /**
     * Set the name of the position
     * 
     * @param string|null $name
     */
    public function setName(?string $name): void;

    /**
     * Set the description of the position
     * 
     * @param string|null $description
     */
    public function setDescription(?string $description): void;

    /**
     * Get the position using the position data attributes
     * 
     * @return Position|null
     */
    public function position(): ?Position;

}