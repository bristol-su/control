<?php

namespace BristolSU\ControlDB\Observers\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\PositionPositionTag;

class PositionTagObserverCascadeDelete
{

    /**
     * @var PositionPositionTag
     */
    private $positionPositionTag;

    public function __construct(PositionPositionTag $positionPositionTag)
    {
        $this->positionPositionTag = $positionPositionTag;
    }

    public function delete(PositionTag $positionTag)
    {
        $positions = $this->positionPositionTag->getPositionsThroughTag($positionTag);
        foreach($positions as $position) {
            $this->positionPositionTag->removeTagFromPosition($positionTag, $position);
        }
    }
    
}