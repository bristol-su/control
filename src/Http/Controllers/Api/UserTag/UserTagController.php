<?php

namespace BristolSU\ControlDB\Http\Controllers\Api\UserTag;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Http\Requests\Api\UserTag\UserTagCategoryStoreRequest;
use BristolSU\ControlDB\Http\Requests\Api\UserTag\UserTagCategoryUpdateRequest;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTag;
use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag as UserTagRepository;

class UserTagController extends Controller
{

    public function index(UserTagRepository $userTagRepository)
    {
        return $userTagRepository->all();
    }

    public function show(UserTag $userTag)
    {
        return $userTag;
    }

    public function store(UserTagCategoryStoreRequest $request, UserTagRepository $userTagRepository)
    {
        return $userTagRepository->create(
            $request->input('name'),
            $request->input('description'),
            $request->input('reference'),
            $request->input('tag_category_id')
        );
    }

    public function update(UserTag $userTag, UserTagCategoryUpdateRequest $request)
    {
        if($request->input('name') !== null) {
            $userTag->setName($request->input('name'));
        }
        if($request->input('description') !== null) {
            $userTag->setDescription($request->input('description'));
        }
        if($request->input('reference') !== null) {
            $userTag->setReference($request->input('reference'));
        }
        if($request->input('tag_category_id') !== null) {
            $userTag->setTagCategoryId($request->input('tag_category_id'));
        }

        return $userTag;
    }

    public function destroy(UserTag $userTag, UserTagRepository $userTagRepository)
    {
        $userTagRepository->delete((int) $userTag->id());
    }

}
