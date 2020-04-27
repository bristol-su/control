<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers;

use BristolSU\ControlDB\Contracts\Models\Position as PositionModel;
use BristolSU\ControlDB\Contracts\Repositories\Position as PositionRepository;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Notifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use Illuminate\Support\Collection;

class PositionNotifier extends Notifier implements PositionRepository
{

    /**
     * @var PositionRepository
     */
    private $positionRepository;

    public function __construct(PositionRepository $positionRepository, ObserverStore $observerStore)
    {
        parent::__construct($observerStore, PositionRepository::class);
        $this->positionRepository = $positionRepository;
    }

    /**
     * Get a position by ID
     *
     * @param int $id ID of the position
     * @return PositionModel
     */
    public function getById(int $id): PositionModel
    {
        return $this->positionRepository->getById($id);
    }

    /**
     * Get a position by its data provider ID
     *
     * @param int $dataProviderId
     * @return PositionModel
     */
    public function getByDataProviderId(int $dataProviderId): PositionModel
    {
        return $this->positionRepository->getByDataProviderId($dataProviderId);
    }

    /**
     * Get all positions
     *
     * @return Collection|PositionModel[]
     */
    public function all(): Collection
    {
        return $this->positionRepository->all();
    }

    /**
     * Create a new position
     *
     * @param int $dataProviderId
     * @return PositionModel
     */
    public function create(int $dataProviderId): PositionModel
    {
        $positionModel = $this->positionRepository->create($dataProviderId);
        $this->notify('create', $positionModel);
        return $positionModel;
    }

    /**
     * Delete a position by ID
     *
     * @param int $id
     */
    public function delete(int $id): void
    {
        $positionModel = $this->getById($id);
        $this->positionRepository->delete($id);
        $this->notify('delete', $positionModel);
    }

    /**
     * Update the position model
     *
     * @param int $id
     * @param int $dataProviderId New data provider ID
     * @return PositionModel
     */
    public function update(int $id, int $dataProviderId): PositionModel
    {
        $oldPositionModel = $this->getById($id);
        $newPositionModel = $this->positionRepository->update($id, $dataProviderId);
        $this->notify('update', $oldPositionModel, $newPositionModel);
        return $newPositionModel;
    }

    /**
     * Paginate through all the positions
     *
     * @param int $page The page number to return
     * @param int $perPage The number of results to return per page
     *
     * @return Collection|PositionModel[]
     */
    public function paginate(int $page, int $perPage): Collection
    {
        return $this->positionRepository->paginate($page, $perPage);
    }

    /**
     * Get the number of positions
     *
     * @return int
     */
    public function count(): int
    {
        return $this->positionRepository->count();
    }
}