<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers;

use BristolSU\ControlDB\Contracts\Models\Role as RoleModel;
use BristolSU\ControlDB\Contracts\Repositories\Role;
use BristolSU\ControlDB\Contracts\Repositories\Role as RoleRepository;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Notifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use Illuminate\Support\Collection;

class RoleNotifier extends Notifier implements RoleRepository
{

    /**
     * @var RoleRepository
     */
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository, ObserverStore $observerStore)
    {
        parent::__construct($observerStore, RoleRepository::class);
        $this->roleRepository = $roleRepository;
    }

    /**
     * Get a role by ID
     *
     * @param int $id
     * @return RoleModel
     */
    public function getById(int $id): RoleModel
    {
        return $this->roleRepository->getById($id);
    }

    /**
     * Get all roles
     *
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\Role[]
     */
    public function all(): Collection
    {
        return $this->roleRepository->all();
    }

    /**
     * Get a role by data provider ID
     *
     * @param int $dataProviderId
     * @return RoleModel
     */
    public function getByDataProviderId(int $dataProviderId): RoleModel
    {
        return $this->roleRepository->getByDataProviderId($dataProviderId);
    }

    /**
     * Create a new role
     *
     * @param int $positionId
     * @param int $groupId
     * @param int $dataProviderId
     * @return RoleModel
     */
    public function create(int $positionId, int $groupId, int $dataProviderId): RoleModel
    {
        $roleModel = $this->roleRepository->create($positionId, $groupId, $dataProviderId);
        $this->notify('create', $roleModel);
        return $roleModel;
    }

    /**
     * Delete a role
     *
     * @param int $id
     */
    public function delete(int $id): void
    {
        $roleModel = $this->getById($id);
        $this->roleRepository->delete($id);
        $this->notify('delete', $roleModel);
    }

    /**
     * Update the role model
     *
     * @param int $id
     * @param int $positionId
     * @param int $groupId
     * @param int $dataProviderId New data provider ID
     * @return RoleModel
     */
    public function update(int $id, int $positionId, int $groupId, int $dataProviderId): RoleModel
    {
        $oldRoleModel = $this->getById($id);
        $newRoleModel = $this->roleRepository->update($id, $positionId, $groupId, $dataProviderId);
        $this->notify('update', $oldRoleModel, $newRoleModel);
        return $newRoleModel;
    }

    /**
     * Get all roles that belong to the given group
     *
     * @param \BristolSU\ControlDB\Contracts\Models\Group $group
     * @return Collection|RoleModel[]
     */
    public function allThroughGroup(\BristolSU\ControlDB\Contracts\Models\Group $group): Collection
    {
        return $this->roleRepository->allThroughGroup($group);
    }

    /**
     * Get all roles that belong to the given position
     * @param \BristolSU\ControlDB\Contracts\Models\Position $position
     * @return Collection|RoleModel[]
     */
    public function allThroughPosition(\BristolSU\ControlDB\Contracts\Models\Position $position): Collection
    {
        return $this->roleRepository->allThroughPosition($position);
    }

    /**
     * Paginate through all the roles
     *
     * @param int $page The page number to return
     * @param int $perPage The number of results to return per page
     *
     * @return Collection|RoleModel[]
     */
    public function paginate(int $page, int $perPage): Collection
    {
        return $this->roleRepository->paginate($page, $perPage);
    }

    /**
     * Get the number of roles
     *
     * @return int
     */
    public function count(): int
    {
        return $this->roleRepository->count();
    }
}