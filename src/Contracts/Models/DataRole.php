<?php

namespace BristolSU\ControlDB\Contracts\Models;

use BristolSU\ControlDB\AdditionalProperties\ImplementsAdditionalProperties;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * Handles information about a role
 */
interface DataRole extends ImplementsAdditionalProperties, Arrayable, Jsonable
{

    /**
     * Get the ID of the data role
     * 
     * @return int
     */
    public function id(): int;

    /**
     * Get the name of the role
     * 
     * @return string|null
     */
    public function roleName(): ?string;

    /**
     * Get the email of the role
     * 
     * @return string|null
     */
    public function email(): ?string;

    /**
     * Set the role name
     * 
     * @param string|null $roleName
     */
    public function setRoleName(?string $roleName): void;

    /**
     * Set the role email
     * 
     * @param string|null $email
     */
    public function setEmail(?string $email): void;

    /**
     * Get the role using the data attributes
     * 
     * @return Role|null
     */
    public function role(): ?Role;


}