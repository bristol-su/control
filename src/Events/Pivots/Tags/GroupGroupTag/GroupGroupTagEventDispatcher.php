<?php

namespace BristolSU\ControlDB\Events\Pivots\Tags\GroupGroupTag;

use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\GroupGroupTag;
use Illuminate\Support\Collection;

class GroupGroupTagEventDispatcher implements GroupGroupTag
{

    private GroupGroupTag $baseGroupGroupTag;

    public function __construct(GroupGroupTag $baseGroupGroupTag)
    {
        $this->baseGroupGroupTag = $baseGroupGroupTag;
    }

    public function addTagToGroup(GroupTag $groupTag, Group $group): void
    {
        $this->baseGroupGroupTag->addTagToGroup($groupTag, $group);
        GroupTagged::dispatch($group, $groupTag);
    }

    public function removeTagFromGroup(GroupTag $groupTag, Group $group): void
    {
        $this->baseGroupGroupTag->removeTagFromGroup($groupTag, $group);
        GroupUntagged::dispatch($group, $groupTag);
    }

    public function getTagsThroughGroup(Group $group): Collection
    {
        return $this->baseGroupGroupTag->getTagsThroughGroup($group);
    }

    public function getGroupsThroughTag(GroupTag $groupTag): Collection
    {
        return $this->baseGroupGroupTag->getGroupsThroughTag($groupTag);
    }
}
