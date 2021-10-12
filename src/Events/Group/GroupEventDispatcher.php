<?php

namespace BristolSU\ControlDB\Events\Group;

use BristolSU\ControlDB\Contracts\Models\Group as GroupModel;
use BristolSU\ControlDB\Contracts\Repositories\Group as GroupRepository;
use Illuminate\Support\Collection;

class GroupEventDispatcher implements GroupRepository
{

    private GroupRepository $baseRepository;

    public function __construct(GroupRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }

    public function getById(int $id): GroupModel
    {
        return $this->baseRepository->getById($id);
    }

    public function getByDataProviderId(int $dataProviderId): GroupModel
    {
        return $this->baseRepository->getByDataProviderId($dataProviderId);
    }

    public function all(): Collection
    {
        return $this->baseRepository->all();
    }

    public function create(int $dataProviderId): GroupModel
    {
        $model = $this->baseRepository->create($dataProviderId);
        GroupCreated::dispatch($model);
        return $model;
    }

    public function update(int $id, int $dataProviderId): GroupModel
    {
        $groupArray = $this->baseRepository->getById($id)->toArray();
        $updatedGroup = $this->baseRepository->update($id, $dataProviderId);
        GroupUpdated::dispatch($updatedGroup, array_diff($updatedGroup->toArray(), $groupArray));
        return $updatedGroup;
    }

    public function delete(int $id): void
    {
        GroupDeleted::dispatch($this->baseRepository->getById($id));
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
