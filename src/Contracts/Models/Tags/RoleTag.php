<?php


namespace BristolSU\ControlDB\Contracts\Models\Tags;


use BristolSU\ControlDB\Contracts\Models\Role;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

/**
 * Interface RoleTag
 * @package BristolSU\ControlDB\Contracts\Models
 */
interface RoleTag extends Arrayable, Jsonable
{

    /**
     * ID of the role tag
     *
     * @return int
     */
    public function id(): int;

    /**
     * Name of the tag
     *
     * @return string
     */
    public function name(): string;

    /**
     * Description of the tag
     *
     * @return string
     */
    public function description(): string;

    /**
     * Reference of the tag
     *
     * @return string
     */
    public function reference(): string;

    /**
     * ID of the tag category
     * @return int
     */
    public function categoryId(): int;

    /**
     * Tag Category
     *
     * @return RoleTagCategory
     */
    public function category(): RoleTagCategory;

    /**
     * Full reference of the tag
     *
     * This should be the tag category reference and the tag reference, separated with a period.
     * @return string
     */
    public function fullReference(): string;

    /**
     * Roles that have this tag
     *
     * @return Collection
     */
    public function roles(): Collection;

    public function setName(string $name): void;

    public function setDescription(string $description): void;

    public function setReference(string $reference): void;

    public function setTagCategoryId($categoryId): void;

    public function addRole(Role $role): void;

    public function removeRole(Role $role): void;
}
