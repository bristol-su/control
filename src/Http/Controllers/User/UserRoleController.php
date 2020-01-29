<?php


namespace BristolSU\ControlDB\Http\Controllers\User;


use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\User;

/**
 * Handles the linking of users and roles
 */
class UserRoleController extends Controller
{

    /**
     * Get all roles that belong to a user
     *
     * @param User $user
     * @return \Illuminate\Support\Collection
     */
    public function index(User $user)
    {
        return $user->roles();
    }

    /**
     * Add a role to a user
     *
     * @param User $user
     * @param Role $role
     */
    public function update(User $user, Role $role)
    {
        $user->addRole($role);
    }

    /**
     * Remove a role from a user
     *
     * @param User $user
     * @param Role $role
     */
    public function destroy(User $user, Role $role)
    {
        $user->removeRole($role);
    }

}
