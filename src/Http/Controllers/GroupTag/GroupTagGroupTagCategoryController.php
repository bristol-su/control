<?php

namespace BristolSU\ControlDB\Http\Controllers\GroupTag;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;

/**
 * Handle the link between a group tag and a group tag category
 */
class GroupTagGroupTagCategoryController extends Controller
{

    /**
     * Return the category of the given tag
     * 
     * @param GroupTag $groupTag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory
     */
    public function index(GroupTag $groupTag)
    {
        return $groupTag->category();
    }

}
