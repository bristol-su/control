<?php


namespace BristolSU\ControlDB\Http\Controllers\Role;


use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Role;

/**
 * Handle the link between a role and a position
 */
class RolePositionController extends Controller
{

    /**
     * Get the position from a role
     * 
     * @param Role $role
     * @return \BristolSU\ControlDB\Contracts\Models\Position
     */
    public function index(Role $role)
    {
        return $role->position();
    }

}
