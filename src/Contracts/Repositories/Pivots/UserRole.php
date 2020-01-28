<?php

namespace BristolSU\ControlDB\Contracts\Repositories\Pivots;

use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\User;
use Illuminate\Support\Collection;

/**
 * Handles the assignment between users and roles
 */
interface UserRole
{

    /**
     * Get all users who have a role
     *
     * @param Role $role
     * @return User[]|Collection Users who have the role
     */
    public function getUsersThroughRole(Role $role): Collection;

    /**
     * Get all roles a user has
     *
     * @param User $user
     * @return Role[]|Collection Roles the given user is in
     */
    public function getRolesThroughUser(User $user): Collection;

    /**
     * Assign a user to a role
     *
     * @param User $user User to assign to the role
     * @param Role $role Role to assign the user to
     * @return void 
     */
    public function addUserToRole(User $user, Role $role): void;

    /**
     * Remove a user from a role
     * @param User $user User to remove from the role
     * @param Role $role Role to remove the user from
     * @return void 
     */
    public function removeUserFromRole(User $user, Role $role): void;
}