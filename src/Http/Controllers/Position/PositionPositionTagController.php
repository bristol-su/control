<?php

namespace BristolSU\ControlDB\Http\Controllers\Position;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;

/**
 * Handle the tagging and untagging of positions
 */
class PositionPositionTagController extends Controller
{

    /**
     * Get all tags belonging to the current position
     * 
     * @param Position $position
     * @return \Illuminate\Support\Collection
     */
    public function index(Position $position)
    {
        return $position->tags();
    }

    /**
     * Tag a position
     * 
     * @param Position $position
     * @param PositionTag $positionTag
     */
    public function update(Position $position, PositionTag $positionTag)
    {
        $position->addTag($positionTag);
    }

    /**
     * Untag position
     * 
     * @param Position $position
     * @param PositionTag $positionTag
     */
    public function destroy(Position $position, PositionTag $positionTag)
    {
        $position->removeTag($positionTag);
    }

}
