<?php

namespace BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;
use Illuminate\Support\Collection;

/**
 * Handles the tagging of groups
 */
interface GroupGroupTag
{

    /**
     * Tag a group
     * 
     * @param GroupTag $groupTag Tag to tag the group with
     * @param Group $group Group to tag
     * @return void
     */
    public function addTagToGroup(GroupTag $groupTag, Group $group): void;

    /**
     * Remove a tag from a group
     *
     * @param GroupTag $groupTag Tag to remove from the group
     * @param Group $group Group to remove the tag from
     * @return void 
     */
    public function removeTagFromGroup(GroupTag $groupTag, Group $group): void;

    /**
     * Get all tags a group is tagged with
     * 
     * @param Group $group Group to retrieve tags from
     * @return Collection|GroupTag[] Tags the group is tagged with
     */
    public function getTagsThroughGroup(Group $group): Collection;

    /**
     * Get all groups tagged with a tag
     * 
     * @param GroupTag $groupTag Tag to use to retrieve groups
     * @return Collection|Group[] Groups tagged with the given tag
     */
    public function getGroupsThroughTag(GroupTag $groupTag): Collection;
    
}