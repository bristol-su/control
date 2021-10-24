<?php

namespace BristolSU\ControlDB\Events\DataRole;

use BristolSU\ControlDB\Contracts\Models\DataRole as DataRoleModel;
use BristolSU\ControlDB\Contracts\Repositories\DataRole as DataRoleRepository;
use Illuminate\Support\Collection;

class DataRoleEventDispatcher implements DataRoleRepository
{

    private DataRoleRepository $baseRepository;

    public function __construct(DataRoleRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }

    public function getById(int $id): DataRoleModel
    {
        return $this->baseRepository->getById($id);
    }

    public function getWhere($attributes = []): DataRoleModel
    {
        return $this->baseRepository->getWhere($attributes);
    }

    public function getAllWhere($attributes = []): Collection
    {
        return $this->baseRepository->getAllWhere($attributes);
    }

    public function create(?string $roleName = null, ?string $email = null): DataRoleModel
    {
        $model = $this->baseRepository->create($roleName, $email);
        DataRoleCreated::dispatch($model);
        return $model;
    }

    public function update(int $id, ?string $roleName = null, ?string $email = null): DataRoleModel
    {
        $dataRoleArray = $this->baseRepository->getById($id)->toArray();
        $updatedDataRole = $this->baseRepository->update($id, $roleName, $email);
        $updatedData = array_filter([
            'role_name' => $roleName === $dataRoleArray['role_name'] ? null : $roleName,
            'email' => $email === $dataRoleArray['email'] ? null : $email,
        ]);
        DataRoleUpdated::dispatch($updatedDataRole, $updatedData);
        return $updatedDataRole;
    }
}
