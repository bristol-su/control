<?php

namespace BristolSU\ControlDB\Http\Controllers\Api\UserTag;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTag;

class UserTagUserTagCategoryController extends Controller
{

    public function index(UserTag $userTag)
    {
        return $userTag->category();
    }

}
