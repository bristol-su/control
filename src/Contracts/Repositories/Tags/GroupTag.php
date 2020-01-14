<?php


namespace BristolSU\ControlDB\Contracts\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Group;
use Illuminate\Support\Collection;

/**
 * Interface GroupTag
 * @package BristolSU\ControlDB\Contracts\Repositories
 */
abstract class GroupTag
{

    /**
     * Get all group tags
     *
     * @return Collection
     */
    abstract public function all(): Collection;

    /**
     * Get all group tags which a group is tagged with
     *
     * @param Group $group
     * @return Collection
     */
    public function allThroughGroup(Group $group): Collection {
        return $group->tags();
    }

    /**
     * Get a tag by the full reference
     *
     * The full reference looks like 'tag_category_ref.tag_ref'
     *
     * @param string $reference
     * @return mixed
     */
    abstract public function getTagByFullReference(string $reference): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;

    /**
     * Get a group tag by id
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
     */
    abstract public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;

    /**
     * Get all group tags belonging to a group tag category
     *
     * @param  $groupTagCategory
     * @return Collection
     */
    public function allThroughGroupTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory $groupTagCategory): Collection {
        return $groupTagCategory->tags();
    }

    abstract public function create(string $name, string $description, string $reference, $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;

    abstract public function delete(int $id);
}
