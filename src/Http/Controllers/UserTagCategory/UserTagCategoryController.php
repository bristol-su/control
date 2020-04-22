<?php

namespace BristolSU\ControlDB\Http\Controllers\UserTagCategory;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Http\Requests\Api\UserTagCategory\UserTagCategoryStoreRequest;
use BristolSU\ControlDB\Http\Requests\Api\UserTagCategory\UserTagCategoryUpdateRequest;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory;
use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTagCategory as UserTagCategoryRepository;

/**
 * Handle user tag categories
 */
class UserTagCategoryController extends Controller
{
    /**
     * Get all user tag categories
     * @param UserTagCategoryRepository $userTagCategoryRepository
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(UserTagCategoryRepository $userTagCategoryRepository)
    {
        return $this->paginate($userTagCategoryRepository->all());
    }

    /**
     * Get information about a single tag category
     * 
     * @param UserTagCategory $userTagCategory
     * @return UserTagCategory
     */
    public function show(UserTagCategory $userTagCategory)
    {
        return $userTagCategory;
    }

    /**
     * Create a new tag category
     * 
     * @param UserTagCategoryStoreRequest $request
     * @param UserTagCategoryRepository $userTagCategoryRepository
     * @return UserTagCategory
     */
    public function store(UserTagCategoryStoreRequest $request, UserTagCategoryRepository $userTagCategoryRepository)
    {
        return $userTagCategoryRepository->create(
            $request->input('name'),
            $request->input('description'),
            $request->input('reference')
        );
    }

    /**
     * Update a tag category
     * 
     * @param UserTagCategory $userTagCategory
     * @param UserTagCategoryUpdateRequest $request
     * @return UserTagCategory
     */
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

    /**
     * Delete a tag category
     * 
     * @param UserTagCategory $userTagCategory
     * @param UserTagCategoryRepository $userTagCategoryRepository
     */
    public function destroy(UserTagCategory $userTagCategory, UserTagCategoryRepository $userTagCategoryRepository)
    {
        $userTagCategoryRepository->delete((int) $userTagCategory->id());
    }

}
