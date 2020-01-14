<?php


namespace BristolSU\ControlDB\Contracts\Models\Tags;


use BristolSU\ControlDB\Contracts\Models\User;
use Illuminate\Support\Collection;

/**
 * Interface UserTag
 * @package BristolSU\ControlDB\Contracts\Models
 */
interface UserTag
{

    /**
     * ID of the user tag
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
     * @return UserTagCategory
     */
    public function category(): UserTagCategory;

    /**
     * Full reference of the tag
     *
     * This should be the tag category reference and the tag reference, separated with a period.
     * @return string
     */
    public function fullReference(): string;

    /**
     * Users who have this tag
     *
     * @return Collection
     */
    public function users(): Collection;

    public function setName(string $name);

    public function setDescription(string $description);

    public function setReference(string $reference);

    public function setTagCategoryId($categoryId);

    public function addUser(User $user);
    
    public function removeUser(User $user);
}
