<?php

namespace BristolSU\ControlDB\Http\Controllers\RoleTag;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;

/**
 * Handle the link between a role tag and a role tag category
 */
class RoleTagRoleTagCategoryController extends Controller
{

    /**
     * Return the category of the given tag
     * 
     * @param RoleTag $roleTag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory
     */
    public function index(RoleTag $roleTag)
    {
        return $roleTag->category();
    }

}
