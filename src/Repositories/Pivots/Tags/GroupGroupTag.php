<?php

namespace BristolSU\ControlDB\Repositories\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\GroupGroupTag as GroupGroupTagContract;
use Illuminate\Support\Collection;

class GroupGroupTag implements GroupGroupTagContract
{

    /**
     * @inheritDoc
     */
    public function addTagToGroup(GroupTag $groupTag, Group $group): void
    {
        \BristolSU\ControlDB\Models\Pivots\Tags\GroupGroupTag::create([
            'tag_id' => $groupTag->id(), 'taggable_id' => $group->id()
        ]);
    }

    /**
     * @inheritDoc
     */
    public function removeTagFromGroup(GroupTag $groupTag, Group $group): void
    {
        \BristolSU\ControlDB\Models\Pivots\Tags\GroupGroupTag::where([
            'tag_id' => $groupTag->id(), 'taggable_id' => $group->id()
        ])->delete();    
    }

    /**
     * @inheritDoc
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
     * @inheritDoc
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