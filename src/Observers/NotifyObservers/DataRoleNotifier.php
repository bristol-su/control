<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers;

use BristolSU\ControlDB\Contracts\Repositories\DataRole as DataRoleRepository;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Notifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use Illuminate\Support\Collection;

class DataRoleNotifier extends Notifier implements DataRoleRepository
{

    /**
     * @var DataRoleRepository
     */
    private $dataRoleRepository;

    public function __construct(DataRoleRepository $dataRoleRepository, ObserverStore $observerStore)
    {
        parent::__construct($observerStore, DataRoleRepository::class);
        $this->dataRoleRepository = $dataRoleRepository;
    }

    /**
     * Get a data role by ID
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\DataRole
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\DataRole
    {
        return $this->dataRoleRepository->getById($id);
    }

    /**
     * Get a data role where the given attributes match, including additional attributes.
     *
     * @param array $attributes
     * @return \BristolSU\ControlDB\Contracts\Models\DataRole
     */
    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataRole
    {
        return $this->dataRoleRepository->getWhere($attributes);
    }

    /**
     * Get all data roles where the given attributes match, including additional attributes.
     *
     * @param array $attributes
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\DataRole[]
     */
    public function getAllWhere($attributes = []): Collection
    {
        return $this->dataRoleRepository->getAllWhere($attributes);
    }

    /**
     * Create a data role with the given attributes
     *
     * @param string|null $roleName Custom name for the role
     * @param string|null $email Email of the role
     * @return \BristolSU\ControlDB\Contracts\Models\DataRole
     */
    public function create(?string $roleName = null, ?string $email = null): \BristolSU\ControlDB\Contracts\Models\DataRole
    {
        $dataRole = $this->dataRoleRepository->create($roleName, $email);
        $this->notify('create', $dataRole);
        return $dataRole;
    }

    /**
     * Update a role with the given attributes
     *
     * @param int $id
     * @param string|null $roleName Name of the role
     * @param string|null $email Email of the role
     * @return \BristolSU\ControlDB\Contracts\Models\DataRole
     */
    public function update(int $id, ?string $roleName = null, ?string $email = null): \BristolSU\ControlDB\Contracts\Models\DataRole
    {
        $oldDataRole = $this->getById($id);
        $newDataRole = $this->dataRoleRepository->update($id, $roleName, $email);
        $this->notify('update', $oldDataRole, $newDataRole);
        return $newDataRole;
    }
    
    
}