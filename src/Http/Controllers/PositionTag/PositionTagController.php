<?php

namespace BristolSU\ControlDB\Http\Controllers\PositionTag;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;
use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag as PositionTagRepository;
use BristolSU\ControlDB\Http\Requests\Api\PositionTag\PositionTagStoreRequest;
use BristolSU\ControlDB\Http\Requests\Api\PositionTag\PositionTagUpdateRequest;

/**
 * Handle position tags
 */
class PositionTagController extends Controller
{

    /**
     * Get all position tags
     * 
     * @param PositionTagRepository $positionTagRepository
     * @return PositionTag[]|\Illuminate\Support\Collection
     */
    public function index(PositionTagRepository $positionTagRepository)
    {
        return $positionTagRepository->all();
    }

    /**
     * Show information about a single position tag
     * 
     * @param PositionTag $positionTag
     * @return PositionTag
     */
    public function show(PositionTag $positionTag)
    {
        return $positionTag;
    }

    /**
     * Create a new position tag
     * 
     * @param PositionTagStoreRequest $request
     * @param PositionTagRepository $positionTagRepository
     * @return PositionTag
     */
    public function store(PositionTagStoreRequest $request, PositionTagRepository $positionTagRepository)
    {
        return $positionTagRepository->create(
            $request->input('name'),
            $request->input('description'),
            $request->input('reference'),
            $request->input('tag_category_id')
        );
    }

    /**
     * Update a position tag
     * 
     * @param PositionTag $positionTag
     * @param PositionTagUpdateRequest $request
     * @return PositionTag
     */
    public function update(PositionTag $positionTag, PositionTagUpdateRequest $request)
    {
        if($request->input('name') !== null) {
            $positionTag->setName($request->input('name'));
        }
        if($request->input('description') !== null) {
            $positionTag->setDescription($request->input('description'));
        }
        if($request->input('reference') !== null) {
            $positionTag->setReference($request->input('reference'));
        }
        if($request->input('tag_category_id') !== null) {
            $positionTag->setTagCategoryId($request->input('tag_category_id'));
        }

        return $positionTag;
    }

    /**
     * Delete a position tag
     * 
     * @param PositionTag $positionTag
     * @param PositionTagRepository $positionTagRepository
     */
    public function destroy(PositionTag $positionTag, PositionTagRepository $positionTagRepository)
    {
        $positionTagRepository->delete((int) $positionTag->id());
    }

}
