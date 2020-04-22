<?php

namespace BristolSU\ControlDB\Http\Controllers\GroupTag;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;
use BristolSU\ControlDB\Contracts\Models\Group;

/**
 * Handle the link between a group tag and a group
 */
class GroupTagGroupController extends Controller
{
    /**
     * Get all groups with the given tag
     * 
     * @param GroupTag $groupTag
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(GroupTag $groupTag)
    {
        return $this->paginate($groupTag->groups());
    }

    /**
     * Add the group to the tag
     * 
     * @param GroupTag $groupTag
     * @param Group $group
     */
    public function update(GroupTag $groupTag, Group $group)
    {
        $groupTag->addGroup($group);
    }

    /**
     * Remove the group from the tag
     * 
     * @param GroupTag $groupTag
     * @param Group $group
     */
    public function destroy(GroupTag $groupTag, Group $group)
    {
        $groupTag->removeGroup($group);
    }

}
