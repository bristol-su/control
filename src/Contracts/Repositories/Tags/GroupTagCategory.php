<?php

namespace BristolSU\ControlDB\Contracts\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory as GroupTagCategoryModel;
use Illuminate\Support\Collection;

/**
 * Manages group tag categories
 */
interface GroupTagCategory
{

    /**
     * Get all group tag categories
     *
     * @return Collection|GroupTagCategoryModel[]
     */
    public function all(): Collection;

    /**
     * Get a tag category by the reference
     *
     * @param string $reference Reference of the tag
     * @return GroupTagCategoryModel
     */
    public function getByReference(string $reference): GroupTagCategoryModel;

    /**
     * Get a group tag category by id
     *
     * @param int $id
     * @return GroupTagCategoryModel
     */
    public function getById(int $id): GroupTagCategoryModel;

    /**
     * Delete a group tag category
     * 
     * @param int $id ID of the group tag category to delete
     */
    public function delete(int $id): void;

    /**
     * Create a group tag category
     * 
     * @param string $name Name of the group tag category
     * @param string $description Description of the group tag category
     * @param string $reference Reference of the group tag category
     * @return GroupTagCategoryModel New group tag category
     */
    public function create(string $name, string $description, string $reference): GroupTagCategoryModel;

    /**
     * Update a group tag category
     *
     * @param int $id
     * @param string $name Name of the group tag category
     * @param string $description Description of the group tag category
     * @param string $reference Reference of the group tag category
     * @return GroupTagCategoryModel New group tag category
     */
    public function update(int $id, string $name, string $description, string $reference): GroupTagCategoryModel;
}
