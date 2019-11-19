<?php


namespace BristolSU\ControlDB\Repositories;


use BristolSU\ControlDB\Models\Group as GroupModel;
use BristolSU\ControlDB\Models\Position as PositionModel;
use BristolSU\ControlDB\Models\Role as RoleModel;
use BristolSU\ControlDB\Models\User as UserModel;
use BristolSU\Support\Control\Contracts\Models\Group;
use BristolSU\Support\Control\Contracts\Models\Position;
use BristolSU\Support\Control\Contracts\Models\User;
use BristolSU\Support\Control\Contracts\Repositories\Role as RoleContract;
use Illuminate\Support\Collection;

/**
 * Class Role
 * @package BristolSU\ControlDB\Repositories
 */
class Role implements RoleContract
{

    /**
     * Get a role by ID
     *
     * @param $id
     * @return \BristolSU\Support\Control\Contracts\Models\Role
     */
    public function getById($id): \BristolSU\Support\Control\Contracts\Models\Role
    {
        return \BristolSU\ControlDB\Models\Role::findOrFail($id);
    }

    /**
     * Get all roles belonging to a user
     *
     * @param User $user
     * @return Collection
     */
    public function allThroughUser(User $user): Collection
    {
        return $user->roles();
    }

    /**
     * Get all roles
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Role::all();
    }

    /**
     * Get all roles belonging to a group
     *
     * @param Group $group
     * @return Collection
     */
    public function allThroughGroup(Group $group): Collection
    {
        return $group->roles();
    }

    /**
     * Get all roles belonging to a position
     *
     * @param Position $position
     * @return Collection
     */
    public function allThroughPosition(Position $position): Collection
    {
        return $position->roles();
    }
}
