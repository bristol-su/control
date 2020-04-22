<?php

namespace BristolSU\ControlDB\Http\Controllers\GroupTag;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;
use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTag as GroupTagRepository;
use BristolSU\ControlDB\Http\Requests\Api\GroupTag\GroupTagStoreRequest;
use BristolSU\ControlDB\Http\Requests\Api\GroupTag\GroupTagUpdateRequest;

/**
 * Handle group tags
 */
class GroupTagController extends Controller
{

    /**
     * Get all group tags
     * 
     * @param GroupTagRepository $groupTagRepository
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(GroupTagRepository $groupTagRepository)
    {
        return $this->paginate($groupTagRepository->all());
    }

    /**
     * Show information about a single group tag
     * 
     * @param GroupTag $groupTag
     * @return GroupTag
     */
    public function show(GroupTag $groupTag)
    {
        return $groupTag;
    }

    /**
     * Create a new group tag
     * 
     * @param GroupTagStoreRequest $request
     * @param GroupTagRepository $groupTagRepository
     * @return GroupTag
     */
    public function store(GroupTagStoreRequest $request, GroupTagRepository $groupTagRepository)
    {
        return $groupTagRepository->create(
            $request->input('name'),
            $request->input('description'),
            $request->input('reference'),
            $request->input('tag_category_id')
        );
    }

    /**
     * Update a group tag
     * 
     * @param GroupTag $groupTag
     * @param GroupTagUpdateRequest $request
     * @return GroupTag
     */
    public function update(GroupTag $groupTag, GroupTagUpdateRequest $request)
    {
        if($request->input('name') !== null) {
            $groupTag->setName($request->input('name'));
        }
        if($request->input('description') !== null) {
            $groupTag->setDescription($request->input('description'));
        }
        if($request->input('reference') !== null) {
            $groupTag->setReference($request->input('reference'));
        }
        if($request->input('tag_category_id') !== null) {
            $groupTag->setTagCategoryId($request->input('tag_category_id'));
        }

        return $groupTag;
    }

    /**
     * Delete a group tag
     * 
     * @param GroupTag $groupTag
     * @param GroupTagRepository $groupTagRepository
     */
    public function destroy(GroupTag $groupTag, GroupTagRepository $groupTagRepository)
    {
        $groupTagRepository->delete((int) $groupTag->id());
    }

}
