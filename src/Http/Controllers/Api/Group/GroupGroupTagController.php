<?php

namespace BristolSU\ControlDB\Http\Controllers\Api\Group;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;

class GroupGroupTagController extends Controller
{

    public function index(Group $group)
    {
        return $group->tags();
    }

    public function update(Group $group, GroupTag $groupTag)
    {
        return $group->addTag($groupTag);
    }

    public function destroy(Group $group, GroupTag $groupTag)
    {
        $group->removeTag($groupTag);
    }

}
