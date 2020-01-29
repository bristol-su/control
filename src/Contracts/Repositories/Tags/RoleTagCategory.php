<?php


namespace BristolSU\ControlDB\Contracts\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory as RoleTagCategoryModel;
use Illuminate\Support\Collection;

/**
 * Manages role tag categories
 */
interface RoleTagCategory
{

    /**
     * Get all role tag categories
     *
     * @return Collection|RoleTagCategoryModel[]
     */
    public function all(): Collection;

    /**
     * Get a tag category by the reference
     *
     * @param string $reference Reference of the tag
     * @return RoleTagCategoryModel
     */
    public function getByReference(string $reference): RoleTagCategoryModel;

    /**
     * Get a role tag category by id
     *
     * @param int $id
     * @return RoleTagCategoryModel
     */
    public function getById(int $id): RoleTagCategoryModel;

    /**
     * Delete a role tag category
     *
     * @param int $id ID of the role tag category to delete
     */
    public function delete(int $id): void;

    /**
     * Create a role tag category
     *
     * @param string $name Name of the role tag category
     * @param string $description Description of the role tag category
     * @param string $reference Reference of the role tag category
     * @return RoleTagCategoryModel New role tag category
     */
    public function create(string $name, string $description, string $reference): RoleTagCategoryModel;
}
