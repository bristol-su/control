<?php

namespace BristolSU\ControlDB\Events\User;

use BristolSU\ControlDB\Contracts\Models\User as UserModel;
use BristolSU\ControlDB\Contracts\Repositories\User as UserRepository;
use Illuminate\Support\Collection;

class UserEventDispatcher implements UserRepository
{

    private UserRepository $baseRepository;

    public function __construct(UserRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }

    public function getById(int $id): UserModel
    {
        return $this->baseRepository->getById($id);
    }

    public function getByDataProviderId(int $dataProviderId): UserModel
    {
        return $this->baseRepository->getByDataProviderId($dataProviderId);
    }

    public function all(): Collection
    {
        return $this->baseRepository->all();
    }

    public function create(int $dataProviderId): UserModel
    {
        $model = $this->baseRepository->create($dataProviderId);
        UserCreated::dispatch($model);
        return $model;
    }

    public function update(int $id, int $dataProviderId): UserModel
    {
        $userArray = $this->baseRepository->getById($id)->toArray();
        $updatedUser = $this->baseRepository->update($id, $dataProviderId);
        $updatedData = array_filter([
            'data_provider_id' => $dataProviderId === $userArray['data_provider_id'] ? null : $dataProviderId,
        ]);
        UserUpdated::dispatch($updatedUser, $updatedData);
        return $updatedUser;
    }

    public function delete(int $id): void
    {
        UserDeleted::dispatch($this->baseRepository->getById($id));
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
