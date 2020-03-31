<?php

namespace BristolSU\ControlDB\Cache;

use BristolSU\ControlDB\Contracts\Models\Role as RoleModel;
use BristolSU\ControlDB\Contracts\Repositories\Role as RoleRepositoryContract;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class Role implements RoleRepositoryContract
{

    /**
     * @var RoleRepositoryContract
     */
    private $roleRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(RoleRepositoryContract $roleRepository, Repository $cache)
    {
        $this->roleRepository = $roleRepository;
        $this->cache = $cache;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): RoleModel
    {
        return $this->cache->remember(static::class . '@getById:' . $id, 5000, function() use ($id) {
            return $this->roleRepository->getById($id);
        });
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return $this->roleRepository->all();
    }

    /**
     * @inheritDoc
     */
    public function getByDataProviderId(int $dataProviderId): RoleModel
    {
        return $this->cache->remember(static::class . '@getByDataProviderId:' . $dataProviderId, 5000, function() use ($dataProviderId) {
            return $this->roleRepository->getByDataProviderId($dataProviderId);
        });
    }

    /**
     * @inheritDoc
     */
    public function create(int $positionId, int $groupId, int $dataProviderId): RoleModel
    {
        return $this->roleRepository->create($positionId, $groupId, $dataProviderId);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): void
    {
        $this->roleRepository->delete($id);
    }

    /**
     * @inheritDoc
     */
    public function allThroughGroup(\BristolSU\ControlDB\Contracts\Models\Group $group): Collection
    {
        return $this->roleRepository->allThroughGroup($group);
    }

    /**
     * @inheritDoc
     */
    public function allThroughPosition(\BristolSU\ControlDB\Contracts\Models\Position $position): Collection
    {
        return $this->roleRepository->allThroughPosition($position);
    }
}