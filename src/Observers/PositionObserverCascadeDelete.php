<?php

namespace BristolSU\ControlDB\Observers;

use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\PositionPositionTag;
use BristolSU\ControlDB\Contracts\Repositories\Role;

class PositionObserverCascadeDelete
{

    /**
     * @var Role
     */
    private $roleRepository;
    /**
     * @var PositionPositionTag
     */
    private $positionPositionTag;

    public function __construct(Role $roleRepository, PositionPositionTag $positionPositionTag)
    {
        $this->roleRepository = $roleRepository;
        $this->positionPositionTag = $positionPositionTag;
    }

    public function delete(Position $position)
    {
        $this->deleteRoles($position);
        $this->removeTags($position);
    }

    private function deleteRoles(Position $position)
    {
        foreach($this->roleRepository->allThroughPosition($position) as $role) {
            $this->roleRepository->delete($role->id());
        }
    }

    private function removeTags(Position $position)
    {
        foreach($this->positionPositionTag->getTagsThroughPosition($position) as $tag) {
            $this->positionPositionTag->removeTagFromPosition($tag, $position);
        }
    }

}