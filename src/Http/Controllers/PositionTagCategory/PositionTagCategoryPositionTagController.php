<?php

namespace BristolSU\ControlDB\Http\Controllers\PositionTagCategory;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory;

/**
 * Controls the link between a position tag category and a position tag
 */
class PositionTagCategoryPositionTagController extends Controller
{

    /**
     * Get all tags belonging to the position tag category
     * 
     * @param PositionTagCategory $positionTagCategory
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(PositionTagCategory $positionTagCategory)
    {
        return $this->paginate($positionTagCategory->tags());
    }

}
