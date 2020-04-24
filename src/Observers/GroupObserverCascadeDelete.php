<?php

namespace BristolSU\ControlDB\Observers;

use BristolSU\ControlDB\Cache\Pivots\Tags\GroupGroupTag;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserGroup;
use BristolSU\ControlDB\Contracts\Repositories\Role;

class GroupObserverCascadeDelete
{

    /**
     * @var UserGroup
     */
    private $userGroup;
    /**
     * @var Role
     */
    private $role;
    /**
     * @var GroupGroupTag
     */
    private $groupGroupTag;

    public function __construct(UserGroup $userGroup, GroupGroupTag $groupGroupTag, Role $role)
    {
        $this->userGroup = $userGroup;
        $this->role = $role;
        $this->groupGroupTag = $groupGroupTag;
    }

    public function delete(Group $group)
    {
        $this->removeUsers($group);
        $this->removeTags($group);
        $this->deleteRoles($group);
    }

    private function removeUsers(Group $group)
    {
        foreach($this->userGroup->getUsersThroughGroup($group) as $user) {
            $this->userGroup->removeUserFromGroup($user, $group);
        }
    }

    private function removeTags(Group $group)
    {
        foreach($this->groupGroupTag->getTagsThroughGroup($group) as $tag) {
            $this->groupGroupTag->removeTagFromGroup($tag, $group);
        }
    }

    private function deleteRoles(Group $group)
    {
        foreach($this->role->allThroughGroup($group) as $role) {
            $this->role->delete($role->id());
        }
    }

}