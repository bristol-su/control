<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\Support\Control\Contracts\Models\Tags\RoleTag as RoleTagModel;
use BristolSU\Support\Control\Contracts\Models\Tags\RoleTagCategory as RoleTagCategoryModel;
use BristolSU\Support\Control\Contracts\Repositories\Tags\RoleTagCategory as RoleTagCategoryContract;
use Illuminate\Support\Collection;

/**
 * Class RoleTag
 * @package BristolSU\ControlDB\Repositories
 */
class RoleTagCategory implements RoleTagCategoryContract
{

    /**
     * Get all role tag categories
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\RoleTagCategory::all();
    }

    /**
     * Get the role tag category of a role tag
     *
     * @param RoleTagModel $role
     * @return RoleTagCategoryModel
     */
    public function allThroughTag(RoleTagModel $roleTag): RoleTagCategoryModel
    {
        // TODO this method should be changed to getThroughRoleTag
        return $roleTag->category();
    }

    /**
     * Get a tag category by the reference
     *
     * @param $reference
     * @return mixed
     */
    public function getByReference(string $reference): RoleTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\RoleTagCategory::where('reference', $reference)->firstOrFail();
    }

    /**
     * Get a role tag category by id
     *
     * @param int $id
     * @return RoleTagCategoryModel
     */
    public function getById(int $id): RoleTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\RoleTagCategory::findOrFail($id);
    }
}
