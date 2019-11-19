<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\Support\Control\Contracts\Models\Group;
use BristolSU\Support\Control\Contracts\Models\Tags\GroupTagCategory;
use BristolSU\Support\Control\Contracts\Repositories\Tags\GroupTag as GroupTagContract;
use Illuminate\Support\Collection;

/**
 * Class GroupTag
 * @package BristolSU\ControlDB\Repositories
 */
class GroupTag implements GroupTagContract
{

    /**
     * Get all group tags
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTag::all();
    }

    /**
     * Get all group tags which a group is tagged with
     *
     * @param Group $group
     * @return Collection
     */
    public function allThroughGroup(Group $group): Collection
    {
        return $group->tags();
    }

    /**
     * Get a tag by the full reference
     *
     * @param string $reference
     * @return mixed
     */
    public function getTagByFullReference(string $reference): \BristolSU\Support\Control\Contracts\Models\Tags\GroupTag
    {
        return $this->all()->filter(function(\BristolSU\ControlDB\Models\Tags\GroupTag $tag) use ($reference) {
            return $reference === $tag->fullReference();
        })->firstOrFail();
    }

    /**
     * Get a group tag by id
     *
     * @param int $id
     * @return \BristolSU\Support\Control\Contracts\Models\Tags\GroupTag
     */
    public function getById(int $id): \BristolSU\Support\Control\Contracts\Models\Tags\GroupTag
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTag::findOrFail($id);
    }

    /**
     * Get all group tags belonging to a group tag category
     *
     * @param GroupTagCategory $groupTagCategory
     * @return Collection
     */
    public function allThroughGroupTagCategory(GroupTagCategory $groupTagCategory): Collection
    {
        return $groupTagCategory->tags();
    }
}
