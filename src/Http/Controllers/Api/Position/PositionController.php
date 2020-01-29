<?php

namespace BristolSU\ControlDB\Http\Controllers\Api\Position;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Http\Requests\Api\Position\StorePositionRequest;
use BristolSU\ControlDB\Http\Requests\Api\Position\UpdatePositionRequest;
use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Repositories\DataPosition as DataPositionRepository;
use BristolSU\ControlDB\Contracts\Repositories\Position as PositionRepository;

class PositionController extends Controller
{

    public function index(PositionRepository $positionRepository)
    {
        return $positionRepository->all();
    }

    public function show(Position $position)
    {
    	return $position;
    }

    public function store(StorePositionRequest $request, PositionRepository $positionRepository, DataPositionRepository $dataPositionRepository)
    {
        $dataPosition = $dataPositionRepository->create(
            $request->input('name'),
            $request->input('description')
        );

        return $positionRepository->create($dataPosition->id());
    }

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


    public function destroy(Position $position, PositionRepository $positionRepository)
    {
        $positionRepository->delete((int) $position->id());
    }

}