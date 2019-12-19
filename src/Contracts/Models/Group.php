<?php

namespace BristolSU\ControlDB\Contracts\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;

/**
 * Interface Group
 * @package BristolSU\ControlDB\Contracts\Models
 */
abstract class Group extends Authenticatable
{

    /**
     * Name of the group
     * 
     * @return string
     */
    abstract public function name(): string;

    /**
     * Contact email address for the group
     * 
     * @return string|null
     */
    abstract public function email(): ?string;

    /**
     * ID of the group
     * 
     * @return int
     */
    abstract public function id(): int;

    /**
     * Members of the group
     * 
     * @return Collection
     */
    public function members(): Collection {
        
    }

    /**
     * Roles belonging to the group
     * 
     * @return Collection
     */
    public function roles(): Collection {
        
    }

    /**
     * Tags the group is tagged with
     * 
     * @return Collection
     */
    public function tags(): Collection {
        
    }
    
}
