<?php

namespace BristolSU\ControlDB\Events\Position;

use BristolSU\ControlDB\Contracts\Models\Position as PositionModel;
use BristolSU\ControlDB\Contracts\Repositories\Position as PositionRepository;
use Illuminate\Support\Collection;

class PositionEventDispatcher implements PositionRepository
{

    private PositionRepository $baseRepository;

    public function __construct(PositionRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }

    public function getById(int $id): PositionModel
    {
        return $this->baseRepository->getById($id);
    }

    public function getByDataProviderId(int $dataProviderId): PositionModel
    {
        return $this->baseRepository->getByDataProviderId($dataProviderId);
    }

    public function all(): Collection
    {
        return $this->baseRepository->all();
    }

    public function create(int $dataProviderId): PositionModel
    {
        $model = $this->baseRepository->create($dataProviderId);
        PositionCreated::dispatch($model);
        return $model;
    }

    public function update(int $id, int $dataProviderId): PositionModel
    {
        $positionArray = $this->baseRepository->getById($id)->toArray();
        $updatedPosition = $this->baseRepository->update($id, $dataProviderId);
        PositionUpdated::dispatch($updatedPosition, array_diff($updatedPosition->toArray(), $positionArray));
    }

    public function delete(int $id): void
    {
        PositionDeleted::dispatch($this->baseRepository->getById($id));
        $this->baseRepository->delete($id);
    }

    public function paginate(int $page, int $perPage): Collection
    {
        return $this->baseRepository->paginate($page, $perPage);
    }

    public function count(): int
    {
        return $this->baseRepository->count();
    }


}
