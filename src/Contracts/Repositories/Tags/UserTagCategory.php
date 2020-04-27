<?php


namespace BristolSU\ControlDB\Contracts\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory as UserTagCategoryModel;
use Illuminate\Support\Collection;

/**
 * Manages user tag categories
 */
interface UserTagCategory
{

    /**
     * Get all user tag categories
     *
     * @return Collection|UserTagCategoryModel[]
     */
    public function all(): Collection;

    /**
     * Get a tag category by the reference
     *
     * @param string $reference Reference of the tag
     * @return UserTagCategoryModel
     */
    public function getByReference(string $reference): UserTagCategoryModel;

    /**
     * Get a user tag category by id
     *
     * @param int $id
     * @return UserTagCategoryModel
     */
    public function getById(int $id): UserTagCategoryModel;

    /**
     * Delete a user tag category
     *
     * @param int $id ID of the user tag category to delete
     */
    public function delete(int $id): void;

    /**
     * Create a user tag category
     *
     * @param string $name Name of the user tag category
     * @param string $description Description of the user tag category
     * @param string $reference Reference of the user tag category
     * @return UserTagCategoryModel New user tag category
     */
    public function create(string $name, string $description, string $reference): UserTagCategoryModel;

    /**
     * Update a user tag category
     *
     * @param int $id
     * @param string $name Name of the user tag category
     * @param string $description Description of the user tag category
     * @param string $reference Reference of the user tag category
     * @return UserTagCategoryModel Updated user tag category
     */
    public function update(int $id, string $name, string $description, string $reference): UserTagCategoryModel;
}
