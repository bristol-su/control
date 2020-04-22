<?php

namespace BristolSU\ControlDB\Http\Controllers\Position;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Position;

/**
 * Handles roles belonging to the position
 */
class PositionRoleController extends Controller
{

    /**
     * Get all roles which have the given position
     * 
     * @param Position $position
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(Position $position)
    {
        return $this->paginate($position->roles());
    }

}
