<?php

namespace BristolSU\ControlDB\Http\Controllers\Role;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Http\Requests\Api\Role\StoreRoleRequest;
use BristolSU\ControlDB\Http\Requests\Api\Role\UpdateRoleRequest;
use BristolSU\ControlDB\Contracts\Repositories\DataRole as DataRoleRepository;
use BristolSU\ControlDB\Contracts\Repositories\Role as RoleRepository;
use BristolSU\ControlDB\Contracts\Models\Role;

/**
 * Handle roles
 */
class RoleController extends Controller
{

    /**
     * Get all roles
     * 
     * @param RoleRepository $roleRepository
     * @return Role[]|\Illuminate\Support\Collection
     */
    public function index(RoleRepository $roleRepository)
    {
        return $roleRepository->all();
    }

    /**
     * Get information about a specific role
     * 
     * @param Role $role
     * @return Role
     */
    public function show(Role $role)
    {
        return $role;
    }

    /**
     * Create a new role
     * 
     * @param StoreRoleRequest $request
     * @param RoleRepository $roleRepository
     * @param DataRoleRepository $dataRoleRepository
     * @return Role
     */
    public function store(StoreRoleRequest $request, RoleRepository $roleRepository, DataRoleRepository $dataRoleRepository)
    {
        $dataRole = $dataRoleRepository->create(
            $request->input('role_name'),
            $request->input('email')
        );

        return $roleRepository->create($request->input('position_id'), $request->input('group_id'), $dataRole->id());
    }

    /**
     * Update a role
     * 
     * @param Role $role
     * @param UpdateRoleRequest $request
     * @param RoleRepository $roleRepository
     * @param DataRoleRepository $dataRoleRepository
     * @return Role
     */
    public function update(Role $role, UpdateRoleRequest $request, RoleRepository $roleRepository, DataRoleRepository $dataRoleRepository)
    {
        $dataRole = $role->data();

        if($request->input('role_name') !== null) {
            $dataRole->setRoleName($request->input('role_name'));
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

    /**
     * Delete a role
     * 
     * @param Role $role
     * @param RoleRepository $roleRepository
     */
    public function destroy(Role $role, RoleRepository $roleRepository)
    {
        $roleRepository->delete((int) $role->id());
    }


}
