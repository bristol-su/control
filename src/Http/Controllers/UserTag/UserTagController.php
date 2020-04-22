<?php

namespace BristolSU\ControlDB\Http\Controllers\UserTag;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTag;
use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag as UserTagRepository;
use BristolSU\ControlDB\Http\Requests\Api\UserTag\UserTagStoreRequest;
use BristolSU\ControlDB\Http\Requests\Api\UserTag\UserTagUpdateRequest;

/**
 * Handle user tags
 */
class UserTagController extends Controller
{

    /**
     * Get all user tags
     * 
     * @param UserTagRepository $userTagRepository
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(UserTagRepository $userTagRepository)
    {
        return $this->paginate($userTagRepository->all());
    }

    /**
     * Show information about a single user tag
     * 
     * @param UserTag $userTag
     * @return UserTag
     */
    public function show(UserTag $userTag)
    {
        return $userTag;
    }

    /**
     * Create a new user tag
     * 
     * @param UserTagStoreRequest $request
     * @param UserTagRepository $userTagRepository
     * @return UserTag
     */
    public function store(UserTagStoreRequest $request, UserTagRepository $userTagRepository)
    {
        return $userTagRepository->create(
            $request->input('name'),
            $request->input('description'),
            $request->input('reference'),
            $request->input('tag_category_id')
        );
    }

    /**
     * Update a user tag
     * 
     * @param UserTag $userTag
     * @param UserTagUpdateRequest $request
     * @return UserTag
     */
    public function update(UserTag $userTag, UserTagUpdateRequest $request)
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

    /**
     * Delete a user tag
     * 
     * @param UserTag $userTag
     * @param UserTagRepository $userTagRepository
     */
    public function destroy(UserTag $userTag, UserTagRepository $userTagRepository)
    {
        $userTagRepository->delete((int) $userTag->id());
    }

}
