<?php

namespace BristolSU\ControlDB\Cache\Pivots;

use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserRole as UserRoleContract;
use BristolSU\ControlDB\Contracts\Repositories\Role as RoleRepository;
use BristolSU\ControlDB\Contracts\Repositories\User as UserRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class UserRole implements UserRoleContract
{

    /**
     * @var UserRoleContract
     */
    private $userRole;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(UserRoleContract $userRole, Repository $cache)
    {
        $this->userRole = $userRole;
        $this->cache = $cache;
    }

    /**
     * Get all users who are members of a role
     *
     * @param Role $role
     * @return User[]|Collection Users who are members of the role
     */
    public function getUsersThroughRole(Role $role): Collection
    {
        $key = static::class . '@getUsersThroughRole:' . $role->id();
        if(!$this->cache->has($key)) {
            $users = $this->userRole->getUsersThroughRole($role);
            $this->cache->forever($key, $users->map(fn(User $user) => $user->id())->all());
            return $users;
        }
        return collect($this->cache->get($key))
            ->map(fn(int $userId) => app(UserRepository::class)->getById($userId));
    }

    /**
     * Get all roles a user belongs to
     *
     * @param User $user
     * @return Role[]|Collection Roles the user is a member of
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getRolesThroughUser(User $user): Collection
    {
        $key = static::class . '@getRolesThroughUser:' . $user->id();
        if(!$this->cache->has($key)) {
            $roles = $this->userRole->getRolesThroughUser($user);
            $this->cache->forever($key, $roles->map(fn(Role $role) => $role->id())->all());
            return $roles;
        }
        return collect($this->cache->get($key))
            ->map(fn(int $roleId) => app(RoleRepository::class)->getById($roleId));
    }

    /**
     * Add a user to a role
     *
     * @param User $user User to add to the role
     * @param Role $role Role to add the user to
     * @return void
     */
    public function addUserToRole(User $user, Role $role): void
    {
        $this->userRole->addUserToRole($user, $role);
    }

    /**
     * Remove a user from a role
     * @param User $user User to remove from the role
     * @param Role $role Role to remove the user from
     * @return void
     */
    public function removeUserFromRole(User $user, Role $role): void
    {
        $this->userRole->removeUserFromRole($user, $role);
    }

}
