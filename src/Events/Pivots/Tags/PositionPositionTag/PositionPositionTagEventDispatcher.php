<?php

namespace BristolSU\ControlDB\Events\Pivots\Tags\PositionPositionTag;

use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\PositionPositionTag;
use Illuminate\Support\Collection;

class PositionPositionTagEventDispatcher implements PositionPositionTag
{

    private PositionPositionTag $basePositionPositionTag;

    public function __construct(PositionPositionTag $basePositionPositionTag)
    {
        $this->basePositionPositionTag = $basePositionPositionTag;
    }

    public function addTagToPosition(PositionTag $positionTag, Position $position): void
    {
        $this->basePositionPositionTag->addTagToPosition($positionTag, $position);
        PositionTagged::dispatch($position, $positionTag);
    }

    public function removeTagFromPosition(PositionTag $positionTag, Position $position): void
    {
        $this->basePositionPositionTag->removeTagFromPosition($positionTag, $position);
        PositionUntagged::dispatch($position, $positionTag);
    }

    public function getTagsThroughPosition(Position $position): Collection
    {
        return $this->basePositionPositionTag->getTagsThroughPosition($position);
    }

    public function getPositionsThroughTag(PositionTag $positionTag): Collection
    {
        return $this->basePositionPositionTag->getPositionsThroughTag($positionTag);
    }
}
