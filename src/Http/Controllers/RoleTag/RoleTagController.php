<?php

namespace BristolSU\ControlDB\Http\Controllers\RoleTag;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;
use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag as RoleTagRepository;
use BristolSU\ControlDB\Http\Requests\Api\RoleTag\RoleTagStoreRequest;
use BristolSU\ControlDB\Http\Requests\Api\RoleTag\RoleTagUpdateRequest;

/**
 * Handle role tags
 */
class RoleTagController extends Controller
{

    /**
     * Get all role tags
     * 
     * @param RoleTagRepository $roleTagRepository
     * @return RoleTag[]|\Illuminate\Support\Collection
     */
    public function index(RoleTagRepository $roleTagRepository)
    {
        return $roleTagRepository->all();
    }

    /**
     * Show information about a single role tag
     * 
     * @param RoleTag $roleTag
     * @return RoleTag
     */
    public function show(RoleTag $roleTag)
    {
        return $roleTag;
    }

    /**
     * Create a new role tag
     * 
     * @param RoleTagStoreRequest $request
     * @param RoleTagRepository $roleTagRepository
     * @return RoleTag
     */
    public function store(RoleTagStoreRequest $request, RoleTagRepository $roleTagRepository)
    {
        return $roleTagRepository->create(
            $request->input('name'),
            $request->input('description'),
            $request->input('reference'),
            $request->input('tag_category_id')
        );
    }

    /**
     * Update a role tag
     * 
     * @param RoleTag $roleTag
     * @param RoleTagUpdateRequest $request
     * @return RoleTag
     */
    public function update(RoleTag $roleTag, RoleTagUpdateRequest $request)
    {
        if($request->input('name') !== null) {
            $roleTag->setName($request->input('name'));
        }
        if($request->input('description') !== null) {
            $roleTag->setDescription($request->input('description'));
        }
        if($request->input('reference') !== null) {
            $roleTag->setReference($request->input('reference'));
        }
        if($request->input('tag_category_id') !== null) {
            $roleTag->setTagCategoryId($request->input('tag_category_id'));
        }

        return $roleTag;
    }

    /**
     * Delete a role tag
     * 
     * @param RoleTag $roleTag
     * @param RoleTagRepository $roleTagRepository
     */
    public function destroy(RoleTag $roleTag, RoleTagRepository $roleTagRepository)
    {
        $roleTagRepository->delete((int) $roleTag->id());
    }

}
