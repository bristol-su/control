<?php


namespace BristolSU\ControlDB\Contracts\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag as RoleTagModel;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory as RoleTagCategoryModel;
use Illuminate\Support\Collection;

/**
 * Interface RoleTag
 */
interface RoleTagCategory
{

    /**
     * Get all role tag categories
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Get a tag category by the reference
     *
     * @param $reference
     * @return mixed
     */
    public function getByReference(string $reference): RoleTagCategoryModel;

    /**
     * Get a role tag category by id
     *
     * @param int $id
     * @return RoleTagCategoryModel
     */
    public function getById(int $id): RoleTagCategoryModel;

    public function delete(int $id): void;

    public function create(string $name, string $description, string $reference): RoleTagCategoryModel;
}
