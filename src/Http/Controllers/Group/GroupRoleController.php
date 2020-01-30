<?php

namespace BristolSU\ControlDB\Http\Controllers\Group;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Group;

/**
 * Handles the link between a group and a role
 */
class GroupRoleController extends Controller
{

    /**
     * Get all roles belonging to this group
     * 
     * @param Group $group
     * @return \Illuminate\Support\Collection
     */
    public function index(Group $group)
    {
        return $group->roles();
    }

}
