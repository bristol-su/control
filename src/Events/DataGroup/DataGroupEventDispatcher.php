<?php

namespace BristolSU\ControlDB\Events\DataGroup;

use BristolSU\ControlDB\Contracts\Models\DataGroup as DataGroupModel;
use BristolSU\ControlDB\Contracts\Repositories\DataGroup as DataGroupRepository;
use Illuminate\Support\Collection;

class DataGroupEventDispatcher implements DataGroupRepository
{

    private DataGroupRepository $baseRepository;

    public function __construct(DataGroupRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }

    public function getById(int $id): DataGroupModel
    {
        return $this->baseRepository->getById($id);
    }

    public function getWhere($attributes = []): DataGroupModel
    {
        return $this->baseRepository->getWhere($attributes);
    }

    public function getAllWhere($attributes = []): Collection
    {
        return $this->baseRepository->getAllWhere($attributes);
    }

    public function create(?string $name = null, ?string $email = null): DataGroupModel
    {
        $model = $this->baseRepository->create($name, $email);
        DataGroupCreated::dispatch($model);
        return $model;
    }

    public function update(int $id, ?string $name = null, ?string $email = null): DataGroupModel
    {
        $dataGroupArray = $this->baseRepository->getById($id)->toArray();
        $updatedDataGroup = $this->baseRepository->update($id, $name, $email);
        $updatedData = array_filter([
            'name' => $name === $dataGroupArray['name'] ? null : $name,
            'email' => $email === $dataGroupArray['email'] ? null : $email
        ]);
        DataGroupUpdated::dispatch($updatedDataGroup, $updatedData);
        return $updatedDataGroup;
    }
}
