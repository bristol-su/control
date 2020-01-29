<?php

namespace BristolSU\ControlDB\Http\Controllers\PositionTag;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;

/**
 * Handle the link between a position tag and a position tag category
 */
class PositionTagPositionTagCategoryController extends Controller
{

    /**
     * Return the category of the given tag
     * 
     * @param PositionTag $positionTag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory
     */
    public function index(PositionTag $positionTag)
    {
        return $positionTag->category();
    }

}
