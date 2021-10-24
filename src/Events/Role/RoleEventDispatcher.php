<?php

namespace BristolSU\ControlDB\Events\Role;

use BristolSU\ControlDB\Contracts\Models\Role as RoleModel;
use BristolSU\ControlDB\Contracts\Repositories\Role as RoleRepository;
use Illuminate\Support\Collection;

class RoleEventDispatcher implements RoleRepository
{

    private RoleRepository $baseRepository;

    public function __construct(RoleRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }

    public function getById(int $id): RoleModel
    {
        return $this->baseRepository->getById($id);
    }

    public function getByDataProviderId(int $dataProviderId): RoleModel
    {
        return $this->baseRepository->getByDataProviderId($dataProviderId);
    }

    public function all(): Collection
    {
        return $this->baseRepository->all();
    }

    public function delete(int $id): void
    {
        RoleDeleted::dispatch($this->baseRepository->getById($id));
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


    public function allThroughGroup(\BristolSU\ControlDB\Contracts\Models\Group $group): Collection
    {
        return $this->baseRepository->allThroughGroup($group);
    }

    public function allThroughPosition(\BristolSU\ControlDB\Contracts\Models\Position $position): Collection
    {
        return $this->baseRepository->allThroughPosition($position);
    }

    public function create(int $positionId, int $groupId, int $dataProviderId): RoleModel
    {
        $model = $this->baseRepository->create($positionId, $groupId, $dataProviderId);
        RoleCreated::dispatch($model);
        return $model;
    }

    public function update(int $id, int $positionId, int $groupId, int $dataProviderId): RoleModel
    {
        $roleArray = $this->baseRepository->getById($id)->toArray();
        $updatedRole = $this->baseRepository->update($id, $positionId, $groupId, $dataProviderId);
        $updatedData = array_filter([
            'position_id' => $positionId === $roleArray['position_id'] ? null : $positionId,
            'group_id' => $groupId === $roleArray['group_id'] ? null : $groupId,
            'data_provider_id' => $dataProviderId === $roleArray['data_provider_id'] ? null : $dataProviderId,
        ]);
        RoleUpdated::dispatch($updatedRole, $updatedData);
        return $updatedRole;
    }
}
