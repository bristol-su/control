<?php

namespace BristolSU\ControlDB\Repositories\Pivots;

use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Models\Pivots\UserRole as UserRolePivotModel;
use Illuminate\Support\Collection;

/**
 * Handle the relationship between a role and a user
 */
class UserRole implements \BristolSU\ControlDB\Contracts\Repositories\Pivots\UserRole
{

    /**
     * Get all users who have a role
     *
     * @param Role $role
     * @return User[]|Collection Users who have the role
     */
    public function getUsersThroughRole(Role $role): Collection
    {
        $userRepository = app(\BristolSU\ControlDB\Contracts\Repositories\User::class);

        return UserRolePivotModel::where('role_id', $role->id())->get()->map(function(UserRolePivotModel $userRole) use ($userRepository) {
            return $userRepository->getById((int) $userRole->user_id);
        })->unique(function(User $user) {
            return $user->id();
        })->values();
    }

    /**
     * Get all roles a user has
     *
     * @param User $user
     * @return Role[]|Collection Roles the given user is in
     */
    public function getRolesThroughUser(User $user): Collection
    {
        $roleRepository = app(\BristolSU\ControlDB\Contracts\Repositories\Role::class);

        return UserRolePivotModel::where('user_id', $user->id())->get()->map(function(UserRolePivotModel $userRole) use ($roleRepository) {
            return $roleRepository->getById((int) $userRole->role_id);
        })->unique(function(Role $role) {
            return $role->id();
        })->values();
    }

    /**
     * Assign a user to a role
     *
     * @param User $user User to assign to the role
     * @param Role $role Role to assign the user to
     * @return void
     */
    public function addUserToRole(User $user, Role $role): void
    {
        UserRolePivotModel::create([
            'user_id' => $user->id(), 'role_id' => $role->id()
        ]);
    }

    /**
     * Remove a user from a role
     * @param User $user User to remove from the role
     * @param Role $role Role to remove the user from
     * @return void
     */
    public function removeUserFromRole(User $user, Role $role): void
    {
        UserRolePivotModel::where([
            'user_id' => $user->id(), 'role_id' => $role->id()
        ])->delete();
    }
}