<?php

namespace BristolSU\ControlDB\Http\Controllers\Position;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Http\Requests\Api\Position\StorePositionRequest;
use BristolSU\ControlDB\Http\Requests\Api\Position\UpdatePositionRequest;
use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Repositories\DataPosition as DataPositionRepository;
use BristolSU\ControlDB\Contracts\Repositories\Position as PositionRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Handles a position model
 */
class PositionController extends Controller
{

    /**
     * Get all positions
     *
     * @param Request $request
     * @param PositionRepository $positionRepository
     * @return LengthAwarePaginator
     */
    public function index(Request $request, PositionRepository $positionRepository)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        return $this->paginationResponse(
            $positionRepository->paginate($page, $perPage),
            $positionRepository->count()
        );
    }

    public function search(Request $request, PositionRepository $positionRepository, DataPositionRepository $dataPositionRepository)
    {

        $search = [];
        if($request->has('name')) {
            $search['name'] = $request->input('name');
        }
        if($request->has('description')) {
            $search['description'] = $request->input('description');
        }
        $dataPositions = $dataPositionRepository->getAllWhere($search);
        $positions = new Collection();
        foreach($dataPositions as $dataPosition) {
            $position = $dataPosition->position();
            if($position !== null) {
                $positions->push($position);
            }
        }
        return $this->paginate($positions);
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
        foreach($dataPosition->getAdditionalAttributes() as $additionalAttribute) {
            if($request->has($additionalAttribute)) {
                $dataPosition->saveAdditionalAttribute($additionalAttribute, $request->input($additionalAttribute));
            }
        }

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
    public function update(Position $position, UpdatePositionRequest $request, DataPositionRepository $dataPositionRepository)
    {
        $dataPosition = $position->data();
        $dataPositionRepository->update(
            $dataPosition->id(),
            $request->input('name', $dataPosition->name()),
            $request->input('description', $dataPosition->description())
        );
        
        foreach($dataPosition->getAdditionalAttributes() as $additionalAttribute) {
            if($request->has($additionalAttribute)) {
                $dataPosition->saveAdditionalAttribute($additionalAttribute, $request->input($additionalAttribute));
            }
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