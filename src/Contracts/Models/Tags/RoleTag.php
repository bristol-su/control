<?php


namespace BristolSU\ControlDB\Contracts\Models\Tags;


use BristolSU\ControlDB\Contracts\Models\Role;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

/**
 * Represents a Role Tag
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
     *
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
     * Roles who have this tag
     *
     * @return Collection
     */
    public function roles(): Collection;

    /**
     * Set the name of the tag
     *
     * @param string $name
     */
    public function setName(string $name): void;

    /**
     * Set the description of the tag
     *
     * @param string $description
     */
    public function setDescription(string $description): void;

    /**
     * Set the reference of the tag
     *
     * @param string $reference
     */
    public function setReference(string $reference): void;

    /**
     * Set the tag category ID
     *
     * @param int $categoryId
     */
    public function setTagCategoryId(int $categoryId): void;

    /**
     * Add a role to the tag
     *
     * @param Role $role
     */
    public function addRole(Role $role): void;

    /**
     * Remove a role from the tag
     *
     * @param Role $role
     */
    public function removeRole(Role $role): void;
}
