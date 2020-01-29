<?php

namespace BristolSU\ControlDB\Http\Controllers\Api\Group;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\Group;

class GroupRoleController extends Controller
{

    public function index(Group $group)
    {
        return $group->roles();
    }

}
