<?php


namespace BristolSU\ControlDB\Contracts\Models\Tags;


use BristolSU\ControlDB\Contracts\Models\Group;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

/**
 * Represents a Group Tag
 */
interface GroupTag extends Arrayable, Jsonable
{

    /**
     * ID of the group tag
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
     * @return GroupTagCategory
     */
    public function category(): GroupTagCategory;

    /**
     * Full reference of the tag
     *
     * This should be the tag category reference and the tag reference, separated with a period.
     * @return string
     */
    public function fullReference(): string;

    /**
     * Groups who have this tag
     *
     * @return Collection
     */
    public function groups(): Collection;

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
     * Add a group to the tag
     * 
     * @param Group $group
     */
    public function addGroup(Group $group): void;

    /**
     * Remove a group from the tag
     * 
     * @param Group $group
     */
    public function removeGroup(Group $group): void;
}
