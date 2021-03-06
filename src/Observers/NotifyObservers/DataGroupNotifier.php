<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers;

use BristolSU\ControlDB\Contracts\Repositories\DataGroup as DataGroupRepository;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Notifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use Illuminate\Support\Collection;

class DataGroupNotifier extends Notifier implements DataGroupRepository
{

    /**
     * @var DataGroupRepository
     */
    private $dataGroupRepository;

    public function __construct(DataGroupRepository $dataGroupRepository, ObserverStore $observerStore)
    {
        parent::__construct($observerStore, DataGroupRepository::class);
        $this->dataGroupRepository = $dataGroupRepository;
    }

    /**
     * Get a data group by ID
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\DataGroup
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\DataGroup
    {
        return $this->dataGroupRepository->getById($id);
    }

    /**
     * Get a data group where the given attributes match, including additional attributes.
     *
     * @param array $attributes
     * @return \BristolSU\ControlDB\Contracts\Models\DataGroup
     */
    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataGroup
    {
        return $this->dataGroupRepository->getWhere($attributes);
    }

    /**
     * Get all data groups where the given attributes match, including additional attributes.
     *
     * @param array $attributes
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\DataGroup[]
     */
    public function getAllWhere($attributes = []): Collection
    {
        return $this->dataGroupRepository->getAllWhere($attributes);
    }

    /**
     * Create a group with the given attributes
     *
     * @param string|null $name Name of the group
     * @param string|null $email Email of the group
     * @return \BristolSU\ControlDB\Contracts\Models\DataGroup
     */
    public function create(?string $name = null, ?string $email = null): \BristolSU\ControlDB\Contracts\Models\DataGroup
    {
        $dataGroup = $this->dataGroupRepository->create($name, $email);
        $this->notify('create', $dataGroup);
        return $dataGroup;
    }

    /**
     * Update a group with the given attributes
     *
     * @param int $id
     * @param string|null $name Name of the group
     * @param string|null $email Email of the group
     * @return \BristolSU\ControlDB\Contracts\Models\DataGroup
     */
    public function update(int $id, ?string $name = null, ?string $email = null): \BristolSU\ControlDB\Contracts\Models\DataGroup
    {
        $oldDataGroup = $this->getById($id);
        $newDataGroup = $this->dataGroupRepository->update($id, $name, $email);
        $this->notify('update', $oldDataGroup, $newDataGroup);
        return $newDataGroup;
    }
}