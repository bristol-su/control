<?php

namespace BristolSU\ControlDB\Events\DataUser;

use BristolSU\ControlDB\Contracts\Models\DataUser as DataUserModel;
use BristolSU\ControlDB\Contracts\Repositories\DataUser as DataUserRepository;
use Illuminate\Support\Collection;

class DataUserEventDispatcher implements DataUserRepository
{

    private DataUserRepository $baseRepository;

    public function __construct(DataUserRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }

    public function getById(int $id): DataUserModel
    {
        return $this->baseRepository->getById($id);
    }

    public function getWhere($attributes = []): DataUserModel
    {
        return $this->baseRepository->getWhere($attributes);
    }

    public function getAllWhere($attributes = []): Collection
    {
        return $this->baseRepository->getAllWhere($attributes);
    }

    public function create(?string $firstName = null, ?string $lastName = null, ?string $email = null, ?\DateTime $dob = null, ?string $preferredName = null): \BristolSU\ControlDB\Contracts\Models\DataUser
    {
        $model = $this->baseRepository->create($firstName, $lastName, $email, $dob, $preferredName);
        DataUserCreated::dispatch($model);
        return $model;
    }

    public function update(int $id, ?string $firstName = null, ?string $lastName = null, ?string $email = null, ?\DateTime $dob = null, ?string $preferredName = null): DataUserModel
    {
        $dataUserArray = $this->baseRepository->getById($id)->toArray();
        $updatedDataUser = $this->baseRepository->update($id, $firstName, $lastName, $email, $dob, $preferredName);
        DataUserUpdated::dispatch($updatedDataUser, array_diff($updatedDataUser->toArray(), $dataUserArray));
    }
}
