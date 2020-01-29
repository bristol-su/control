<?php

namespace BristolSU\ControlDB\Http\Controllers\Api\UserTagCategory;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Http\Requests\Api\UserTag\UserTagCategoryStoreRequest;
use BristolSU\ControlDB\Http\Requests\Api\UserTag\UserTagCategoryUpdateRequest;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory;
use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTagCategory as UserTagCategoryRepository;

class UserTagCategoryController extends Controller
{

    public function index(UserTagCategoryRepository $userTagCategoryRepository)
    {
        return $userTagCategoryRepository->all();
    }

    public function show(UserTagCategory $userTagCategory)
    {
        return $userTagCategory;
    }

    public function store(UserTagCategoryStoreRequest $request, UserTagCategoryRepository $userTagCategoryRepository)
    {
        return $userTagCategoryRepository->create(
            $request->input('name'),
            $request->input('description'),
            $request->input('reference')
        );
    }

    public function update(UserTagCategory $userTagCategory, UserTagCategoryUpdateRequest $request)
    {
        if($request->input('name') !== null) {
            $userTagCategory->setName($request->input('name'));
        }
        if($request->input('description') !== null) {
            $userTagCategory->setDescription($request->input('description'));
        }
        if($request->input('reference') !== null) {
            $userTagCategory->setReference($request->input('reference'));
        }

        return $userTagCategory;
    }

    public function destroy(UserTagCategory $userTagCategory, UserTagCategoryRepository $userTagCategoryRepository)
    {
        $userTagCategoryRepository->delete((int) $userTagCategory->id());
    }

}
