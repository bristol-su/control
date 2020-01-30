<?php

namespace BristolSU\ControlDB\Http\Controllers\UserTagCategory;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory;

/**
 * Controls the link between a user tag category and a user tag
 */
class UserTagCategoryUserTagController extends Controller
{

    /**
     * Get all tags belonging to the user tag category
     * 
     * @param UserTagCategory $userTagCategory
     * @return \Illuminate\Support\Collection
     */
    public function index(UserTagCategory $userTagCategory)
    {
        return $userTagCategory->tags();
    }

}
