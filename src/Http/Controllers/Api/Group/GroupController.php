<?php

namespace BristolSU\ControlDB\Http\Controllers\Api\Group;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Http\Requests\Api\Group\StoreGroupRequest;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Repositories\DataGroup as DataGroupRepository;
use BristolSU\ControlDB\Contracts\Repositories\Group as GroupRepository;

class GroupController extends Controller
{

    public function index(GroupRepository $groupRepository)
    {
        return $groupRepository->all();
    }

    public function show(Group $group)
    {
        return $group;
    }

    public function store(StoreGroupRequest $request, GroupRepository $groupRepository, DataGroupRepository $dataGroupRepository)
    {
        $dataGroup = $dataGroupRepository->create(
            $request->input('name'),
            $request->input('email')
        );

        return $groupRepository->create($dataGroup->id());
    }

    public function update(Group $group, StoreGroupRequest $request, GroupRepository $groupRepository, DataGroupRepository $dataGroupRepository)
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

    public function destroy(Group $group, GroupRepository $groupRepository)
    {
        $groupRepository->delete((int) $group->id());
    }

}
