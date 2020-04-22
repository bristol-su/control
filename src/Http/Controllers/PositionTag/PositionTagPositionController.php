<?php

namespace BristolSU\ControlDB\Http\Controllers\PositionTag;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;
use BristolSU\ControlDB\Contracts\Models\Position;

/**
 * Handle the link between a position tag and a position
 */
class PositionTagPositionController extends Controller
{
    /**
     * Get all positions with the given tag
     * 
     * @param PositionTag $positionTag
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(PositionTag $positionTag)
    {
        return $this->paginate($positionTag->positions());
    }

    /**
     * Add the position to the tag
     * 
     * @param PositionTag $positionTag
     * @param Position $position
     */
    public function update(PositionTag $positionTag, Position $position)
    {
        $positionTag->addPosition($position);
    }

    /**
     * Remove the position from the tag
     * 
     * @param PositionTag $positionTag
     * @param Position $position
     */
    public function destroy(PositionTag $positionTag, Position $position)
    {
        $positionTag->removePosition($position);
    }

}
