<?php

namespace BristolSU\ControlDB\Http\Controllers\PositionTagCategory;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Http\Requests\Api\PositionTagCategory\PositionTagCategoryStoreRequest;
use BristolSU\ControlDB\Http\Requests\Api\PositionTagCategory\PositionTagCategoryUpdateRequest;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory;
use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTagCategory as PositionTagCategoryRepository;

/**
 * Handle position tag categories
 */
class PositionTagCategoryController extends Controller
{
    /**
     * Get all position tag categories
     * @param PositionTagCategoryRepository $positionTagCategoryRepository
     * @return PositionTagCategory[]|\Illuminate\Support\Collection
     */
    public function index(PositionTagCategoryRepository $positionTagCategoryRepository)
    {
        return $positionTagCategoryRepository->all();
    }

    /**
     * Get information about a single tag category
     * 
     * @param PositionTagCategory $positionTagCategory
     * @return PositionTagCategory
     */
    public function show(PositionTagCategory $positionTagCategory)
    {
        return $positionTagCategory;
    }

    /**
     * Create a new tag category
     * 
     * @param PositionTagCategoryStoreRequest $request
     * @param PositionTagCategoryRepository $positionTagCategoryRepository
     * @return PositionTagCategory
     */
    public function store(PositionTagCategoryStoreRequest $request, PositionTagCategoryRepository $positionTagCategoryRepository)
    {
        return $positionTagCategoryRepository->create(
            $request->input('name'),
            $request->input('description'),
            $request->input('reference')
        );
    }

    /**
     * Update a tag category
     * 
     * @param PositionTagCategory $positionTagCategory
     * @param PositionTagCategoryUpdateRequest $request
     * @return PositionTagCategory
     */
    public function update(PositionTagCategory $positionTagCategory, PositionTagCategoryUpdateRequest $request)
    {
        if($request->input('name') !== null) {
            $positionTagCategory->setName($request->input('name'));
        }
        if($request->input('description') !== null) {
            $positionTagCategory->setDescription($request->input('description'));
        }
        if($request->input('reference') !== null) {
            $positionTagCategory->setReference($request->input('reference'));
        }

        return $positionTagCategory;
    }

    /**
     * Delete a tag category
     * 
     * @param PositionTagCategory $positionTagCategory
     * @param PositionTagCategoryRepository $positionTagCategoryRepository
     */
    public function destroy(PositionTagCategory $positionTagCategory, PositionTagCategoryRepository $positionTagCategoryRepository)
    {
        $positionTagCategoryRepository->delete((int) $positionTagCategory->id());
    }

}
