<?php


namespace BristolSU\ControlDB\Contracts\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag as RoleTagModel;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory as RoleTagCategoryModel;
use Illuminate\Support\Collection;

/**
 * Interface RoleTag
 * @package BristolSU\ControlDB\Contracts\Repositories
 */
abstract class RoleTagCategory
{

    /**
     * Get all role tag categories
     *
     * @return Collection
     */
    abstract public function all(): Collection;

    /**
     * Get the role tag category of a role tag
     *
     * @param RoleTagModel $role
     * @return RoleTagCategoryModel
     */
    public function getThroughTag(RoleTagModel $role): RoleTagCategoryModel {
        return $role->category();
    }

    /**
     * Get a tag category by the reference
     *
     * @param $reference
     * @return mixed
     */
    abstract public function getByReference(string $reference): RoleTagCategoryModel;

    /**
     * Get a role tag category by id
     *
     * @param int $id
     * @return RoleTagCategoryModel
     */
    abstract public function getById(int $id): RoleTagCategoryModel;

    abstract public function delete(int $id);

    abstract public function create(string $name, string $description, string $reference): RoleTagCategoryModel;
}
