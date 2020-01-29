<?php

namespace BristolSU\ControlDB\Http\Controllers\UserTag;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTag;

/**
 * Handle the link between a user tag and a user tag category
 */
class UserTagUserTagCategoryController extends Controller
{

    /**
     * Return the category of the given tag
     * 
     * @param UserTag $userTag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory
     */
    public function index(UserTag $userTag)
    {
        return $userTag->category();
    }

}
