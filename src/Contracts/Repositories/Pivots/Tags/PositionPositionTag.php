<?php

namespace BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;
use Illuminate\Support\Collection;

/**
 * Handles the tagging of positions
 */
interface PositionPositionTag
{

    /**
     * Tag a position
     *
     * @param PositionTag $positionTag Tag to tag the position with
     * @param Position $position Position to tag
     * @return void 
     */
    public function addTagToPosition(PositionTag $positionTag, Position $position): void;

    /**
     * Remove a tag from a position
     *
     * @param PositionTag $positionTag Tag to remove from the position
     * @param Position $position Position to remove the tag from
     * @return void 
     */
    public function removeTagFromPosition(PositionTag $positionTag, Position $position): void;

    /**
     * Get all tags a position is tagged with
     *
     * @param Position $position Position to retrieve tags from
     * @return Collection|PositionTag[] Tags the position is tagged with
     */
    public function getTagsThroughPosition(Position $position): Collection;

    /**
     * Get all positions tagged with a tag
     *
     * @param PositionTag $positionTag Tag to use to retrieve positions
     * @return Collection|Position[] Positions tagged with the given tag
     */
    public function getPositionsThroughTag(PositionTag $positionTag): Collection;

}