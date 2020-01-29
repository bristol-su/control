<?php

namespace BristolSU\ControlDB\Repositories\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\GroupGroupTag as GroupGroupTagContract;
use Illuminate\Support\Collection;

/**
 * Handles the tagging of groups
 */
class GroupGroupTag implements GroupGroupTagContract
{

    /**
     * Tag a group
     *
     * @param GroupTag $groupTag Tag to tag the group with
     * @param Group $group Group to tag
     * @return void
     */
    public function addTagToGroup(GroupTag $groupTag, Group $group): void
    {
        \BristolSU\ControlDB\Models\Pivots\Tags\GroupGroupTag::create([
            'tag_id' => $groupTag->id(), 'taggable_id' => $group->id()
        ]);
    }

    /**
     * Remove a tag from a group
     *
     * @param GroupTag $groupTag Tag to remove from the group
     * @param Group $group Group to remove the tag from
     * @return void
     */
    public function removeTagFromGroup(GroupTag $groupTag, Group $group): void
    {
        \BristolSU\ControlDB\Models\Pivots\Tags\GroupGroupTag::where([
            'tag_id' => $groupTag->id(), 'taggable_id' => $group->id()
        ])->delete();    
    }

    /**
     * Get all tags a group is tagged with
     *
     * @param Group $group Group to retrieve tags from
     * @return Collection|GroupTag[] Tags the group is tagged with
     */
    public function getTagsThroughGroup(Group $group): Collection
    {
        $groupTagRepository = app(\BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTag::class);

        return \BristolSU\ControlDB\Models\Pivots\Tags\GroupGroupTag::where('taggable_id', $group->id())
            ->get()->map(function(\BristolSU\ControlDB\Models\Pivots\Tags\GroupGroupTag $groupGroupTag) use ($groupTagRepository) {
            return $groupTagRepository->getById((int) $groupGroupTag->tag_id);
        })->unique(function(GroupTag $user) {
            return $user->id();
        })->values();
    }

    /**
     * Get all groups tagged with a tag
     *
     * @param GroupTag $groupTag Tag to use to retrieve groups
     * @return Collection|Group[] Groups tagged with the given tag
     */
    public function getGroupsThroughTag(GroupTag $groupTag): Collection
    {
        $groupRepository = app(\BristolSU\ControlDB\Contracts\Repositories\Group::class);

        return \BristolSU\ControlDB\Models\Pivots\Tags\GroupGroupTag::where('tag_id', $groupTag->id())
            ->get()->map(function(\BristolSU\ControlDB\Models\Pivots\Tags\GroupGroupTag $groupGroupTag) use ($groupRepository) {
                return $groupRepository->getById((int) $groupGroupTag->taggable_id);
            })->unique(function(Group $group) {
                return $group->id();
            })->values();
    }
}