<?php


namespace BristolSU\ControlDB\Repositories;


use BristolSU\Support\Control\Contracts\Models\Group as GroupModel;
use BristolSU\Support\Control\Contracts\Models\Role as RoleModel;
use BristolSU\Support\Control\Contracts\Models\User as UserModelContract;
use BristolSU\Support\Control\Contracts\Repositories\User as UserContract;
use Illuminate\Support\Collection;

/**
 * Class User
 * @package BristolSU\ControlDB\Repositories
 */
class User implements UserContract
{

    /**
     * Get a user by their ID
     *
     * @param $id
     * @return UserModelContract
     */
    public function getById(int $id): UserModelContract
    {
        return \BristolSU\ControlDB\Models\User::findOrFail($id);
    }

    /**
     * Get all users
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\User::all();
    }

    /**
     * Get a user by their data platform ID
     *
     * @param int $dataPlatformId
     * @return UserModelContract
     */
    public function getByDataPlatformId(int $dataPlatformId): UserModelContract
    {
        return \BristolSU\ControlDB\Models\User::where('data_provider_id', $dataPlatformId)->firstOrFail();
    }

    /**
     * Create a user
     *
     * @param int $dataPlatformId
     * @return UserModelContract
     */
    public function create(int $dataPlatformId): UserModelContract
    {
        return \BristolSU\ControlDB\Models\User::create([
            'data_provider_id' => $dataPlatformId
        ]);
    }

    /**
     * Get all users with a specific role
     *
     * @param RoleModel $role
     * @return Collection
     */
    public function allThroughRole(RoleModel $role): Collection
    {
        return $role->users();
    }

    /**
     * Get all users of a group
     *
     * @param GroupModel $group
     * @return Collection
     */
    public function allThroughGroup(GroupModel $group): Collection
    {
        return $group->members();
    }
}
