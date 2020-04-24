<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers;

use BristolSU\ControlDB\Contracts\Models\Group as GroupModel;
use BristolSU\ControlDB\Contracts\Repositories\Group as GroupRepository;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Notifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use Illuminate\Support\Collection;

class GroupNotifier extends Notifier implements GroupRepository
{

    /**
     * @var GroupRepository
     */
    private $groupRepository;

    public function __construct(GroupRepository $groupRepository, ObserverStore $observerStore)
    {
        parent::__construct($observerStore, GroupRepository::class);
        $this->groupRepository = $groupRepository;
    }

    /**
     * Get a group by ID
     *
     * @param int $id ID of the group
     * @return GroupModel
     */
    public function getById(int $id): GroupModel
    {
        return $this->groupRepository->getById($id);
    }

    /**
     * Get a group by its data provider ID
     *
     * @param int $dataProviderId
     * @return GroupModel
     */
    public function getByDataProviderId(int $dataProviderId): GroupModel
    {
        return $this->groupRepository->getByDataProviderId($dataProviderId);
    }

    /**
     * Get all groups
     *
     * @return Collection|GroupModel[]
     */
    public function all(): Collection
    {
        return $this->groupRepository->all();
    }

    /**
     * Create a new group
     *
     * @param int $dataProviderId
     * @return GroupModel
     */
    public function create(int $dataProviderId): GroupModel
    {
        $groupModel = $this->groupRepository->create($dataProviderId);
        $this->notify('create', $groupModel);
        return $groupModel;
    }

    /**
     * Delete a group by ID
     *
     * @param int $id
     */
    public function delete(int $id): void
    {
        $groupModel = $this->getById($id);
        $this->groupRepository->delete($id);
        $this->notify('delete', $groupModel);
    }

    /**
     * Update the group model
     *
     * @param int $id
     * @param int $dataProviderId New data provider ID
     * @return GroupModel
     */
    public function update(int $id, int $dataProviderId): GroupModel
    {
        $oldGroupModel = $this->getById($id);
        $newGroupModel = $this->groupRepository->update($id, $dataProviderId);
        $this->notify('update', $oldGroupModel, $newGroupModel);
        return $newGroupModel;
    }

    /**
     * Paginate through all the groups
     *
     * @param int $page The page number to return
     * @param int $perPage The number of results to return per page
     *
     * @return Collection|GroupModel[]
     */
    public function paginate(int $page, int $perPage): Collection
    {
        return $this->groupRepository->paginate($page, $perPage);
    }

    /**
     * Get the number of groups
     *
     * @return int
     */
    public function count(): int
    {
        return $this->groupRepository->count();
    }
}