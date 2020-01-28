<?php


namespace BristolSU\ControlDB\Contracts\Models\Tags;


use BristolSU\ControlDB\Contracts\Models\Group;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

/**
 * Interface GroupTag
 * @package BristolSU\ControlDB\Contracts\Models
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

    public function setName(string $name): void;

    public function setDescription(string $description): void;

    public function setReference(string $reference): void;

    public function setTagCategoryId($categoryId): void;

    public function addGroup(Group $group): void;

    public function removeGroup(Group $group): void;
}
