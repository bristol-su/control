<?php

namespace BristolSU\ControlDB\Contracts\Models\Tags;

use Illuminate\Support\Collection;

/**
 * Interface GroupTag
 * @package BristolSU\ControlDB\Contracts\Models
 */
abstract class GroupTagCategory
{

    /**
     * ID of the tag category
     * 
     * @return mixed
     */
    abstract public function id();

    /**
     * Name of the tag category
     * 
     * @return string
     */
    abstract public function name(): string;

    /**
     * Deacription of the tag category
     * 
     * @return string
     */
    abstract public function description(): string;

    /**
     * Reference of the tag category
     * 
     * @return string
     */
    abstract public function reference(): string;

    /**
     * All tags under this tag category
     * 
     * @return Collection
     */
    public function tags(): Collection {
        
    }
}