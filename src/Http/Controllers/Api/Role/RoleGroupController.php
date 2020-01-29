<?php


namespace BristolSU\ControlDB\Http\Controllers\Api\Role;


use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Role;

class RoleGroupController extends Controller
{

    public function index(Role $role)
    {
        return $role->group();
    }

}