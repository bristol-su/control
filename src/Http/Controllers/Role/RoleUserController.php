<?php


namespace BristolSU\ControlDB\Http\Controllers\Role;


use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\User;

/**
 * Handles the link between a role and a user
 */
class RoleUserController extends Controller
{

    /**
     * Get all users belonging to a group
     * 
     * @param Role $role
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(Role $role)
    {
        return $this->paginate($role->users());
    }

    /**
     * Add a user to a role
     * 
     * @param Role $role
     * @param User $user
     */
    public function update(Role $role, User $user)
    {
        $role->addUser($user);
    }

    /**
     * Remove a user from a role
     * 
     * @param Role $role
     * @param User $user
     */
    public function destroy(Role $role, User $user)
    {
        $role->removeUser($user);
    }

}
