<?php


namespace BristolSU\ControlDB\Http\Controllers\Api\User;


use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\User;

class UserRoleController extends Controller
{

    public function index(User $user)
    {
        return $user->roles();
    }

    public function update(User $user, Role $role)
    {
        $user->addRole($role);
    }

    public function destroy(User $user, Role $role)
    {
        $user->removeRole($role);
    }

}
