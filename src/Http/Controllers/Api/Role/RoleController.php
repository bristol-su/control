<?php

namespace BristolSU\ControlDB\Http\Controllers\Api\Role;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Http\Requests\Api\Role\StoreRoleRequest;
use BristolSU\ControlDB\Http\Requests\Api\Role\UpdateRoleRequest;
use BristolSU\ControlDB\Contracts\Repositories\DataRole as DataRoleRepository;
use BristolSU\ControlDB\Contracts\Repositories\Role as RoleRepository;
use BristolSU\ControlDB\Contracts\Models\Role;

class RoleController extends Controller
{
    public function index(RoleRepository $roleRepository)
    {
        return $roleRepository->all();
    }

    public function show(Role $role)
    {
        return $role;
    }

    public function store(StoreRoleRequest $request, RoleRepository $roleRepository, DataRoleRepository $dataRoleRepository)
    {
        $dataRole = $dataRoleRepository->create(
            $request->input('position_name'),
            $request->input('email')
        );

        return $roleRepository->create($request->input('position_id'), $request->input('group_id'), $dataRole->id());
    }

    public function update(Role $role, UpdateRoleRequest $request, RoleRepository $roleRepository, DataRoleRepository $dataRoleRepository)
    {
        $dataRole = $role->data();

        if($request->input('position_name') !== null) {
            $dataRole->setPositionName($request->input('position_name'));
        }
        if($request->input('email') !== null) {
            $dataRole->setEmail($request->input('email'));
        }

        if($request->input('position_id') !== null) {
            $role->setPositionId($request->input('position_id'));
        }

        if($request->input('group_id') !== null) {
            $role->setGroupId($request->input('group_id'));
        }

        return $role;
    }

    public function destroy(Role $role, RoleRepository $roleRepository)
    {
        $roleRepository->delete((int) $role->id());
    }


}
