<?php

namespace BristolSU\ControlDB\Events\Pivots\Tags\GroupGroupTag;

use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;
use BristolSU\ControlDB\Contracts\Models\Group;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GroupTagged
{
    use Dispatchable, SerializesModels;

    public Group $group;
    public GroupTag $groupTag;

    public function __construct(Group $group, GroupTag $groupTag)
    {
        $this->group = $group;
        $this->groupTag = $groupTag;
    }

}
