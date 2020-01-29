<?php

namespace BristolSU\ControlDB\Http\Controllers\Group;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;

/**
 * Handles a group tags link to a group
 */
class GroupGroupTagController extends Controller
{

    /**
     * Get all group tags through a group
     * 
     * @param Group $group
     * @return \Illuminate\Support\Collection
     */
    public function index(Group $group)
    {
        return $group->tags();
    }

    /**
     * Tag a group
     * 
     * @param Group $group
     * @param GroupTag $groupTag
     */
    public function update(Group $group, GroupTag $groupTag)
    {
        $group->addTag($groupTag);
    }

    /**
     * Remove a tag from a group
     * 
     * @param Group $group
     * @param GroupTag $groupTag
     */
    public function destroy(Group $group, GroupTag $groupTag)
    {
        $group->removeTag($groupTag);
    }

}
