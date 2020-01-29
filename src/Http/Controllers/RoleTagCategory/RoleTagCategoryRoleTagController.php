<?php

namespace BristolSU\ControlDB\Http\Controllers\RoleTagCategory;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory;

/**
 * Controls the link between a role tag category and a role tag
 */
class RoleTagCategoryRoleTagController extends Controller
{

    /**
     * Get all tags belonging to the role tag category
     * 
     * @param RoleTagCategory $roleTagCategory
     * @return \Illuminate\Support\Collection
     */
    public function index(RoleTagCategory $roleTagCategory)
    {
        return $roleTagCategory->tags();
    }

}
