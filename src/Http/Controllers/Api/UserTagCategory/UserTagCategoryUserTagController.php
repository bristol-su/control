<?php

namespace BristolSU\ControlDB\Http\Controllers\Api\UserTagCategory;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory;

class UserTagCategoryUserTagController extends Controller
{

    public function index(UserTagCategory $userTagCategory)
    {
        return $userTagCategory->tags();
    }

}
