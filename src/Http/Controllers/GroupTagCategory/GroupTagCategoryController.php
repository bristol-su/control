<?php

namespace BristolSU\ControlDB\Http\Controllers\GroupTagCategory;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Http\Requests\Api\GroupTagCategory\GroupTagCategoryStoreRequest;
use BristolSU\ControlDB\Http\Requests\Api\GroupTagCategory\GroupTagCategoryUpdateRequest;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory;
use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTagCategory as GroupTagCategoryRepository;

/**
 * Handle group tag categories
 */
class GroupTagCategoryController extends Controller
{
    /**
     * Get all group tag categories
     * @param GroupTagCategoryRepository $groupTagCategoryRepository
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(GroupTagCategoryRepository $groupTagCategoryRepository)
    {
        return $this->paginate($groupTagCategoryRepository->all());
    }

    /**
     * Get information about a single tag category
     * 
     * @param GroupTagCategory $groupTagCategory
     * @return GroupTagCategory
     */
    public function show(GroupTagCategory $groupTagCategory)
    {
        return $groupTagCategory;
    }

    /**
     * Create a new tag category
     * 
     * @param GroupTagCategoryStoreRequest $request
     * @param GroupTagCategoryRepository $groupTagCategoryRepository
     * @return GroupTagCategory
     */
    public function store(GroupTagCategoryStoreRequest $request, GroupTagCategoryRepository $groupTagCategoryRepository)
    {
        return $groupTagCategoryRepository->create(
            $request->input('name'),
            $request->input('description'),
            $request->input('reference')
        );
    }

    /**
     * Update a tag category
     * 
     * @param GroupTagCategory $groupTagCategory
     * @param GroupTagCategoryUpdateRequest $request
     * @return GroupTagCategory
     */
    public function update(GroupTagCategory $groupTagCategory, GroupTagCategoryUpdateRequest $request)
    {
        if($request->input('name') !== null) {
            $groupTagCategory->setName($request->input('name'));
        }
        if($request->input('description') !== null) {
            $groupTagCategory->setDescription($request->input('description'));
        }
        if($request->input('reference') !== null) {
            $groupTagCategory->setReference($request->input('reference'));
        }

        return $groupTagCategory;
    }

    /**
     * Delete a tag category
     * 
     * @param GroupTagCategory $groupTagCategory
     * @param GroupTagCategoryRepository $groupTagCategoryRepository
     */
    public function destroy(GroupTagCategory $groupTagCategory, GroupTagCategoryRepository $groupTagCategoryRepository)
    {
        $groupTagCategoryRepository->delete((int) $groupTagCategory->id());
    }

}
