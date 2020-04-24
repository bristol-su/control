<?php

namespace BristolSU\ControlDB\Observers\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\GroupGroupTag;

class GroupTagObserverCascadeDelete
{

    /**
     * @var GroupGroupTag
     */
    private $groupGroupTag;

    public function __construct(GroupGroupTag $groupGroupTag)
    {
        $this->groupGroupTag = $groupGroupTag;
    }

    public function delete(GroupTag $groupTag)
    {
        $groups = $this->groupGroupTag->getGroupsThroughTag($groupTag);
        foreach($groups as $group) {
            $this->groupGroupTag->removeTagFromGroup($groupTag, $group);
        }
    }
    
}