<?php

namespace BristolSU\ControlDB\Observers\Pivots;

use BristolSU\ControlDB\Cache\Pivots\UserRole as UserRoleCache;
use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\User;
use Illuminate\Contracts\Cache\Repository;

class UserRoleObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function addUserToRole(User $user, Role $role)
    {
        $this->cache->forget(UserRoleCache::class . '@getRolesThroughUser:' . $user->id());
        $this->cache->forget(UserRoleCache::class . '@getUsersThroughRole:' . $role->id());
    }

    public function removeUserFromRole(User $user, Role $role): void
    {
        $this->cache->forget(UserRoleCache::class . '@getRolesThroughUser:' . $user->id());
        $this->cache->forget(UserRoleCache::class . '@getUsersThroughRole:' . $role->id());
    }

}