<?php


namespace BristolSU\ControlDB\Contracts\Models\Tags;


use Illuminate\Support\Collection;

/**
 * Interface RoleTag
 * @package BristolSU\ControlDB\Contracts\Models
 */
abstract class RoleTag
{

    /**
     * ID of the role tag
     * 
     * @return int
     */
    abstract public function id(): int;

    /**
     * Name of the tag
     * 
     * @return string
     */
    abstract public function name(): string;

    /**
     * Description of the tag
     * 
     * @return string
     */
    abstract public function description(): string;

    /**
     * Reference of the tag
     * 
     * @return string
     */
    abstract public function reference(): string;

    /**
     * ID of the tag category
     * @return int
     */
    abstract public function categoryId(): int;

    /**
     * Tag Category
     * 
     * @return RoleTagCategory
     */
    public function category(): RoleTagCategory {
        
    }

    /**
     * Full reference of the tag
     * 
     * This should be the tag category reference and the tag reference, separated with a period.
     * @return string
     */
    public function fullReference(): string {
        
    }

    /**
     * Roles that have this tag
     * 
     * @return Collection
     */
    public function roles(): Collection {
        
    }
}
