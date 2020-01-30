<?php

namespace BristolSU\ControlDB\Contracts\Models;

use BristolSU\ControlDB\AdditionalProperties\ImplementsAdditionalProperties;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * Holds information about a group
 */
interface DataGroup extends ImplementsAdditionalProperties, Arrayable, Jsonable
{

    /**
     * Get the ID of the group
     *
     * @return int
     */
    public function id(): int;

    /**
     * Get the name of the group
     * 
     * @return string|null
     */
    public function name(): ?string;

    /**
     * Get the email of the group
     * 
     * @return string|null
     */
    public function email(): ?string;

    /**
     * Set the name of the group
     *
     * @param string|null $name
     */
    public function setName(?string $name): void;

    /**
     * Set the email of the group
     *
     * @param string|null $email
     */
    public function setEmail(?string $email): void;

    /**
     * Get the group using the data group
     * 
     * @return Group|null
     */
    public function group(): ?Group;

}