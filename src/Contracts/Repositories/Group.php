<?php

namespace BristolSU\ControlDB\Contracts\Repositories;

use BristolSU\ControlDB\Contracts\Models\User as UserModel;
use BristolSU\ControlDB\Contracts\Models\Group as GroupModel;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag as GroupTagModel;
use Illuminate\Support\Collection;

/**
 * Interface Group
 * @package BristolSU\ControlDB\Contracts\Repositories
 */
abstract class Group
{

    /**
     * Get a group by ID
     *
     * @param $id
     * @return GroupModel
     */
    abstract public function getById(int $id): GroupModel;

    /**
     * Get all groups with a specific tag
     *
     * @param GroupTagModel $groupTag
     * @return Collection
     */
    public function getThroughTag(GroupTagModel $groupTag): Collection {
        return $groupTag->groups();
    }

    /**
     * Get all groups
     *
     * @return Collection
     */
    abstract public function all(): Collection;

    /**
     * Get all groups the given user is a member of
     *
     * @param $id
     * @return Collection
     */
    public function allThroughUser(UserModel $user): Collection {
        return $user->groups();
    }

    abstract public function create(int $dataProviderId): GroupModel;
    
    abstract public function delete(int $id);

}
