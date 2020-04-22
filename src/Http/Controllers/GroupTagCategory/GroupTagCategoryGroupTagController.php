<?php

namespace BristolSU\ControlDB\Http\Controllers\GroupTagCategory;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory;

/**
 * Controls the link between a group tag category and a group tag
 */
class GroupTagCategoryGroupTagController extends Controller
{

    /**
     * Get all tags belonging to the group tag category
     * 
     * @param GroupTagCategory $groupTagCategory
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(GroupTagCategory $groupTagCategory)
    {
        return $this->paginate($groupTagCategory->tags());
    }

}
