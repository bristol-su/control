<?php

namespace BristolSU\ControlDB\Http\Controllers\Group;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Http\Requests\Api\Group\StoreGroupRequest;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Repositories\DataGroup as DataGroupRepository;
use BristolSU\ControlDB\Contracts\Repositories\Group as GroupRepository;

/**
 * Handles groups
 */
class GroupController extends Controller
{

    /**
     * Get all groups
     * 
     * @param GroupRepository $groupRepository
     * @return Group[]|\Illuminate\Support\Collection
     */
    public function index(GroupRepository $groupRepository)
    {
        return $groupRepository->all();
    }

    /**
     * Get information about a specific group
     * 
     * @param Group $group
     * @return Group
     */
    public function show(Group $group)
    {
        return $group;
    }

    /**
     * Create a group
     * 
     * Accepts the parameters name and email
     * 
     * @param StoreGroupRequest $request
     * @param GroupRepository $groupRepository
     * @param DataGroupRepository $dataGroupRepository
     * @return Group
     */
    public function store(StoreGroupRequest $request, GroupRepository $groupRepository, DataGroupRepository $dataGroupRepository)
    {
        $dataGroup = $dataGroupRepository->create(
            $request->input('name'),
            $request->input('email')
        );

        return $groupRepository->create($dataGroup->id());
    }

    /**
     * Update a group
     * 
     * Accepts name and/or email
     * @param Group $group
     * @param StoreGroupRequest $request
     * @return Group
     */
    public function update(Group $group, StoreGroupRequest $request)
    {
        $dataGroup = $group->data();
        if($request->input('name') !== null) {
            $dataGroup->setName($request->input('name'));
        }
        if($request->input('email') !== null) {
            $dataGroup->setEmail($request->input('email'));
        }

        return $group;
    }

    /**
     * Delete a group
     * 
     * @param Group $group
     * @param GroupRepository $groupRepository
     */
    public function destroy(Group $group, GroupRepository $groupRepository)
    {
        $groupRepository->delete((int) $group->id());
    }

}
