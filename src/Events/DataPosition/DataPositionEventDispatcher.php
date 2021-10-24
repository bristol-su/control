<?php

namespace BristolSU\ControlDB\Events\DataPosition;

use BristolSU\ControlDB\Contracts\Models\DataPosition as DataPositionModel;
use BristolSU\ControlDB\Contracts\Repositories\DataPosition as DataPositionRepository;
use Illuminate\Support\Collection;

class DataPositionEventDispatcher implements DataPositionRepository
{

    private DataPositionRepository $baseRepository;

    public function __construct(DataPositionRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }

    public function getById(int $id): DataPositionModel
    {
        return $this->baseRepository->getById($id);
    }

    public function getWhere($attributes = []): DataPositionModel
    {
        return $this->baseRepository->getWhere($attributes);
    }

    public function getAllWhere($attributes = []): Collection
    {
        return $this->baseRepository->getAllWhere($attributes);
    }

    public function create(?string $name = null, ?string $description = null): DataPositionModel
    {
        $model = $this->baseRepository->create($name, $description);
        DataPositionCreated::dispatch($model);
        return $model;
    }

    public function update(int $id, ?string $name = null, ?string $description = null): DataPositionModel
    {
        $dataPositionArray = $this->baseRepository->getById($id)->toArray();
        $updatedDataPosition = $this->baseRepository->update($id, $name, $description);
        $updatedData = array_filter([
            'name' => $name=== $dataPositionArray['name'] ? null : $name,
            'description' => $description === $dataPositionArray['description'] ? null : $description,
        ]);
        DataPositionUpdated::dispatch($updatedDataPosition, $updatedData);
        return $updatedDataPosition;
    }
}
