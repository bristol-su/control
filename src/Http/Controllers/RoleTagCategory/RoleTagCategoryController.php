<?php

namespace BristolSU\ControlDB\Http\Controllers\RoleTagCategory;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Http\Requests\Api\RoleTagCategory\RoleTagCategoryStoreRequest;
use BristolSU\ControlDB\Http\Requests\Api\RoleTagCategory\RoleTagCategoryUpdateRequest;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory;
use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTagCategory as RoleTagCategoryRepository;

/**
 * Handle role tag categories
 */
class RoleTagCategoryController extends Controller
{
    /**
     * Get all role tag categories
     * @param RoleTagCategoryRepository $roleTagCategoryRepository
     * @return RoleTagCategory[]|\Illuminate\Support\Collection
     */
    public function index(RoleTagCategoryRepository $roleTagCategoryRepository)
    {
        return $roleTagCategoryRepository->all();
    }

    /**
     * Get information about a single tag category
     * 
     * @param RoleTagCategory $roleTagCategory
     * @return RoleTagCategory
     */
    public function show(RoleTagCategory $roleTagCategory)
    {
        return $roleTagCategory;
    }

    /**
     * Create a new tag category
     * 
     * @param RoleTagCategoryStoreRequest $request
     * @param RoleTagCategoryRepository $roleTagCategoryRepository
     * @return RoleTagCategory
     */
    public function store(RoleTagCategoryStoreRequest $request, RoleTagCategoryRepository $roleTagCategoryRepository)
    {
        return $roleTagCategoryRepository->create(
            $request->input('name'),
            $request->input('description'),
            $request->input('reference')
        );
    }

    /**
     * Update a tag category
     * 
     * @param RoleTagCategory $roleTagCategory
     * @param RoleTagCategoryUpdateRequest $request
     * @return RoleTagCategory
     */
    public function update(RoleTagCategory $roleTagCategory, RoleTagCategoryUpdateRequest $request)
    {
        if($request->input('name') !== null) {
            $roleTagCategory->setName($request->input('name'));
        }
        if($request->input('description') !== null) {
            $roleTagCategory->setDescription($request->input('description'));
        }
        if($request->input('reference') !== null) {
            $roleTagCategory->setReference($request->input('reference'));
        }

        return $roleTagCategory;
    }

    /**
     * Delete a tag category
     * 
     * @param RoleTagCategory $roleTagCategory
     * @param RoleTagCategoryRepository $roleTagCategoryRepository
     */
    public function destroy(RoleTagCategory $roleTagCategory, RoleTagCategoryRepository $roleTagCategoryRepository)
    {
        $roleTagCategoryRepository->delete((int) $roleTagCategory->id());
    }

}
