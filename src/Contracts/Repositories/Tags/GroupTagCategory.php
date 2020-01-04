<?php


namespace BristolSU\ControlDB\Contracts\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag as GroupTagModel;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory as GroupTagCategoryModel;
use Illuminate\Support\Collection;

/**
 * Interface GroupTag
 * @package BristolSU\ControlDB\Contracts\Repositories
 */
abstract class GroupTagCategory
{

    /**
     * Get all group tag categories
     * 
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Get the group tag category of a group tag
     * 
     * @param GroupTagModel $group
     * @return GroupTagCategoryModel
     */
    public function allThroughTag(GroupTagModel $group): GroupTagCategoryModel;

    /**
     * Get a tag category by the reference
     * 
     * @param $reference
     * @return mixed
     */
    public function getByReference(string $reference): GroupTagCategoryModel;
    
    /**
     * Get a group tag category by id
     * 
     * @param int $id
     * @return GroupTagCategoryModel
     */
    public function getById(int $id): GroupTagCategoryModel;
}
