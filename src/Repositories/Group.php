<?php

namespace BristolSU\ControlDB\Repositories;

use BristolSU\Support\Control\Contracts\Models\Tags\GroupTag;
use BristolSU\Support\Control\Contracts\Models\User;
use BristolSU\Support\Control\Contracts\Repositories\Group as GroupContract;
use Illuminate\Support\Collection;

/**
 * Class Group
 * @package BristolSU\ControlDB\Repositories
 */
class Group extends GroupContract
{


    /**
     * Get a group by ID
     *
     * @param $id
     * @return \BristolSU\Support\Control\Contracts\Models\Group
     */
    public function getById(int $id): \BristolSU\Support\Control\Contracts\Models\Group
    {
        return \BristolSU\ControlDB\Models\Group::findOrFail($id);
    }

    /**
     * Get all groups with a specific tag
     *
     * @param GroupTag $groupTag
     * @return Collection
     */
    public function allThroughTag(GroupTag $groupTag): Collection
    {
        return $groupTag->groups();
    }

    /**
     * Get all groups
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Group::all();
    }

    /**
     * Get all groups the given user is a member of
     *
     * @param $id
     * @return Collection
     */
    public function allThroughUser(User $user): Collection
    {
        return $user->groups();
    }
}
