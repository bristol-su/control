<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers;

use BristolSU\ControlDB\Contracts\Repositories\DataPosition as DataPositionRepository;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Notifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use Illuminate\Support\Collection;

class DataPositionNotifier extends Notifier implements DataPositionRepository
{

    /**
     * @var DataPositionRepository
     */
    private $dataPositionRepository;

    public function __construct(DataPositionRepository $dataPositionRepository, ObserverStore $observerStore)
    {
        parent::__construct($observerStore, DataPositionRepository::class);
        $this->dataPositionRepository = $dataPositionRepository;
    }

    /**
     * Get a data position by ID
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\DataPosition
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\DataPosition
    {
        return $this->dataPositionRepository->getById($id);
    }

    /**
     * Get a data position where the given attributes match, including additional attributes.
     *
     * @param array $attributes
     * @return \BristolSU\ControlDB\Contracts\Models\DataPosition
     */
    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataPosition
    {
        return $this->dataPositionRepository->getWhere($attributes);
    }

    /**
     * Get all data positions where the given attributes match, including additional attributes.
     *
     * @param array $attributes
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\DataPosition[]
     */
    public function getAllWhere($attributes = []): Collection
    {
        return $this->dataPositionRepository->getAllWhere($attributes);
    }

    /**
     * Create a data position with the given attributes
     *
     * @param string|null $name Name of the position
     * @param string|null $description Description of the position
     * @return \BristolSU\ControlDB\Contracts\Models\DataPosition
     */
    public function create(?string $name = null, ?string $description = null): \BristolSU\ControlDB\Contracts\Models\DataPosition
    {
        $dataPosition = $this->dataPositionRepository->create($name, $description);
        $this->notify('create', $dataPosition);
        return $dataPosition;
    }

    /**
     * Update a data position with the given attributes
     *
     * @param int $id
     * @param string|null $name Name of the position
     * @param string|null $description Description of the position
     * @return \BristolSU\ControlDB\Contracts\Models\DataPosition
     */
    public function update(int $id, ?string $name = null, ?string $description = null): \BristolSU\ControlDB\Contracts\Models\DataPosition
    {
        $oldDataPosition = $this->getById($id);
        $newDataPosition = $this->dataPositionRepository->update($id, $name, $description);
        $this->notify('update', $oldDataPosition, $newDataPosition);
        return $newDataPosition;
    }
}