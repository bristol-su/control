<?php


namespace BristolSU\ControlDB\Contracts\Repositories;


use BristolSU\ControlDB\Contracts\Models\Group as GroupModel;
use BristolSU\ControlDB\Contracts\Models\Role as RoleModel;
use BristolSU\ControlDB\Contracts\Models\User as UserModelContract;
use Illuminate\Support\Collection;

/**
 * Interface User
 * @package BristolSU\ControlDB\Contracts\Repositories
 */
abstract class User
{

    /**
     * Get a user by their ID
     * 
     * @param $id
     * @return UserModelContract
     */
    public function getById(int $id): UserModelContract;

    /**
     * Get all users
     * 
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Get a user by their data platform ID
     * 
     * @param int $dataPlatformId
     * @return UserModelContract
     */
    public function getByDataPlatformId(int $dataPlatformId) : UserModelContract;

    /**
     * Create a user 
     * 
     * @param int $dataPlatformId
     * @return UserModelContract
     */
    public function create(int $dataPlatformId): UserModelContract;

    /**
     * Get all users with a specific role
     * 
     * @param RoleModel $role
     * @return Collection
     */
    public function allThroughRole(RoleModel $role): Collection;

    /**
     * Get all users of a group
     * 
     * @param GroupModel $group
     * @return Collection
     */
    public function allThroughGroup(GroupModel $group): Collection;
}
