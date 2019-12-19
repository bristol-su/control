<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\Support\Control\Contracts\Models\Tags\GroupTag as GroupTagModel;
use BristolSU\Support\Control\Contracts\Models\Tags\GroupTagCategory as GroupTagCategoryModel;
use BristolSU\Support\Control\Contracts\Repositories\Tags\GroupTagCategory as GroupTagCategoryContract;
use Illuminate\Support\Collection;

/**
 * Class GroupTag
 * @package BristolSU\ControlDB\Repositories
 */

class GroupTagCategory extends GroupTagCategoryContract
{

    /**
     * Get all group tag categories
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTagCategory::all();
    }

    /**
     * Get the group tag category of a group tag
     *
     * @param GroupTagModel $group
     * @return GroupTagCategoryModel
     */
    public function allThroughTag(GroupTagModel $groupTag): GroupTagCategoryModel
    {
        // TODO this method should be changed to getThroughGroupTag
        return $groupTag->category();
    }

    /**
     * Get a tag category by the reference
     *
     * @param $reference
     * @return mixed
     */
    public function getByReference(string $reference): GroupTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTagCategory::where('reference', $reference)->firstOrFail();
    }

    /**
     * Get a group tag category by id
     *
     * @param int $id
     * @return GroupTagCategoryModel
     */
    public function getById(int $id): GroupTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTagCategory::findOrFail($id);
    }
}
