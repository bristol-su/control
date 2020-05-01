<?php

namespace BristolSU\ControlDB\Http\Controllers\Group;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Http\Requests\Api\Group\StoreGroupRequest;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Repositories\DataGroup as DataGroupRepository;
use BristolSU\ControlDB\Contracts\Repositories\Group as GroupRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Handles groups
 */
class GroupController extends Controller
{

    /**
     * Get all groups
     *
     * @param Request $request
     * @param GroupRepository $groupRepository
     * @return LengthAwarePaginator
     */
    public function index(Request $request, GroupRepository $groupRepository)
    {
        $perPage = request()->input('per_page', 10);
        $page = request()->input('page', 1);
        
        return $this->paginationResponse(
            $groupRepository->paginate($page, $perPage),
            $groupRepository->count()
        );
    }

    public function search(Request $request, GroupRepository $groupRepository, DataGroupRepository $dataGroupRepository)
    {
        $search = [];
        if($request->has('name')) {
            $search['name'] = $request->input('name');
        }
        if($request->has('email')) {
            $search['email'] = $request->input('email');
        }
        $dataGroups = $dataGroupRepository->getAllWhere($search);
        $groups = new Collection();
        foreach($dataGroups as $dataGroup) {
            $group = $dataGroup->group();
            if($group !== null) {
                $groups->push($group);
            }
        }

        return $this->paginate($groups);
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
        
        foreach($dataGroup->getAdditionalAttributes() as $additionalAttribute) {
            if($request->has($additionalAttribute)) {
                $dataGroup->saveAdditionalAttribute($additionalAttribute, $request->input($additionalAttribute));
            }
        }

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
    public function update(Group $group, StoreGroupRequest $request, DataGroupRepository $dataGroupRepository)
    {
        $dataGroup = $group->data();
        $dataGroupRepository->update(
            $group->dataProviderId(),
            $request->input('name', $dataGroup->name()),
            $request->input('email', $dataGroup->email())
        );
        
        foreach($dataGroup->getAdditionalAttributes() as $additionalAttribute) {
            if($request->has($additionalAttribute)) {
                $dataGroup->saveAdditionalAttribute($additionalAttribute, $request->input($additionalAttribute));
            }
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
