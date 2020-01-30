<?php

namespace BristolSU\ControlDB\Http\Controllers\Position;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Http\Requests\Api\Position\StorePositionRequest;
use BristolSU\ControlDB\Http\Requests\Api\Position\UpdatePositionRequest;
use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Repositories\DataPosition as DataPositionRepository;
use BristolSU\ControlDB\Contracts\Repositories\Position as PositionRepository;

/**
 * Handles a position model
 */
class PositionController extends Controller
{

    /**
     * Get all positions
     * 
     * @param PositionRepository $positionRepository
     * @return Position[]|\Illuminate\Support\Collection
     */
    public function index(PositionRepository $positionRepository)
    {
        return $positionRepository->all();
    }

    /**
     * Return information about a single position
     * 
     * @param Position $position
     * @return Position
     */
    public function show(Position $position)
    {
    	return $position;
    }

    /**
     * Create a new position
     * 
     * @param StorePositionRequest $request
     * @param PositionRepository $positionRepository
     * @param DataPositionRepository $dataPositionRepository
     * @return Position
     */
    public function store(StorePositionRequest $request, PositionRepository $positionRepository, DataPositionRepository $dataPositionRepository)
    {
        $dataPosition = $dataPositionRepository->create(
            $request->input('name'),
            $request->input('description')
        );

        return $positionRepository->create($dataPosition->id());
    }

    /**
     * Update a position
     * 
     * @param Position $position
     * @param UpdatePositionRequest $request
     * @param PositionRepository $positionRepository
     * @param DataPositionRepository $dataPositionRepository
     * @return Position
     */
    public function update(Position $position, UpdatePositionRequest $request, PositionRepository $positionRepository, DataPositionRepository $dataPositionRepository)
    {
        $dataPosition = $position->data();

        if($request->input('name') !== null) {
            $dataPosition->setName($request->input('name'));
        }
        if($request->input('description') !== null) {
            $dataPosition->setDescription($request->input('description'));
        }

        return $position;
    }

    /**
     * Delete a position
     * 
     * @param Position $position
     * @param PositionRepository $positionRepository
     */
    public function destroy(Position $position, PositionRepository $positionRepository)
    {
        $positionRepository->delete((int) $position->id());
    }

}