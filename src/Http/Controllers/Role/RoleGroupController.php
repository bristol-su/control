<?php


namespace BristolSU\ControlDB\Http\Controllers\Role;


use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Role;

/**
 * Handle the link between a role and a group
 */
class RoleGroupController extends Controller
{

    /**
     * Get the group from a role
     * 
     * @param Role $role
     * @return \BristolSU\ControlDB\Contracts\Models\Group
     */
    public function index(Role $role)
    {
        return $role->group();
    }

}
