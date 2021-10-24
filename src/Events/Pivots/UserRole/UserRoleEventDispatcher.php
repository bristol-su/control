<?php

namespace BristolSU\ControlDB\Events\Pivots\UserRole;

use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserRole;
use Illuminate\Support\Collection;

class UserRoleEventDispatcher implements UserRole
{

    private UserRole $baseUserRole;

    public function __construct(UserRole $baseUserRole)
    {
        $this->baseUserRole = $baseUserRole;
    }

    public function getUsersThroughRole(Role $role): Collection
    {
        return $this->baseUserRole->getUsersThroughRole($role);
    }

    public function getRolesThroughUser(User $user): Collection
    {
        return $this->baseUserRole->getRolesThroughUser($user);
    }

    public function addUserToRole(User $user, Role $role): void
    {
        $this->baseUserRole->addUserToRole($user, $role);
        UserAddedToRole::dispatch($user, $role);
    }

    public function removeUserFromRole(User $user, Role $role): void
    {
        $this->baseUserRole->removeUserFromRole($user, $role);
        UserRemovedFromRole::dispatch($user, $role);
    }
}
