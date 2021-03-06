<?php

namespace BristolSU\ControlDB\Http\Controllers\Role;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Http\Requests\Api\Role\StoreRoleRequest;
use BristolSU\ControlDB\Http\Requests\Api\Role\UpdateRoleRequest;
use BristolSU\ControlDB\Contracts\Repositories\DataRole as DataRoleRepository;
use BristolSU\ControlDB\Contracts\Repositories\Role as RoleRepository;
use BristolSU\ControlDB\Contracts\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Handle roles
 */
class RoleController extends Controller
{

    /**
     * Get all roles
     *
     * @param Request $request
     * @param RoleRepository $roleRepository
     * @return LengthAwarePaginator
     */
    public function index(Request $request, RoleRepository $roleRepository)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        return $this->paginationResponse(
            $roleRepository->paginate($page, $perPage),
            $roleRepository->count()
        );
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
        
        foreach($dataRole->getAdditionalAttributes() as $additionalAttribute) {
            if($request->has($additionalAttribute)) {
                $dataRole->saveAdditionalAttribute($additionalAttribute, $request->input($additionalAttribute));
            }
        }
        
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
        
        $dataRoleRepository->update(
            $dataRole->id(),
            $request->input('role_name', $dataRole->roleName()),
            $request->input('email', $dataRole->email()),
        );
        
        $roleRepository->update(
            $role->id(),
            $request->input('position_id', $role->positionId()),
            $request->input('group_id', $role->groupId()),
            $dataRole->id()
        );
        
        foreach($dataRole->getAdditionalAttributes() as $additionalAttribute) {
            if($request->has($additionalAttribute)) {
                $dataRole->saveAdditionalAttribute($additionalAttribute, $request->input($additionalAttribute));
            }
        }
        
        return $roleRepository->getById($role->id());
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
