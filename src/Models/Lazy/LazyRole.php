<?php

namespace BristolSU\ControlDB\Models\Lazy;

use BristolSU\ControlDB\Contracts\Models\DataRole;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Models\Role as RoleContract;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Repositories\Role as RoleRepository;
use Illuminate\Support\Collection;

class LazyRole extends LazyModel implements RoleContract
{

    public function toArray()
    {
        return $this->model()->toArray();
    }

    public function toJson($options = 0)
    {
        return $this->model()->toJson($options);
    }

    public function id(): int
    {
        return $this->model()->id();
    }

    public function dataProviderId(): int
    {
        return $this->model()->dataProviderId();
    }

    public function setDataProviderId(int $dataProviderId): void
    {
        $this->model()->setDataProviderId($dataProviderId);
    }

    public function data(): DataRole
    {
        return $this->model()->data();
    }

    protected function resolveModelFromId(int $id)
    {
        return app(RoleRepository::class)->getById($id);
    }

    public function positionId(): int
    {
        return $this->model()->positionId();
    }

    public function groupId(): int
    {
        return $this->model()->groupId();
    }

    public function setGroupId(int $groupId): void
    {
        $this->model()->setGroupId($groupId);
    }

    public function setPositionId(int $positionId): void
    {
        $this->model()->setPositionId($positionId);
    }

    public function position(): Position
    {
        return $this->model()->position();
    }

    public function group(): Group
    {
        return $this->model()->group();
    }

    public function users(): Collection
    {
        return $this->model()->users();
    }

    public function tags(): Collection
    {
        return $this->model()->tags();
    }

    public function addTag(RoleTag $roleTag): void
    {
        $this->model()->addTag($roleTag);
    }

    public function removeTag(RoleTag $roleTag): void
    {
        $this->model()->removeTag($roleTag);
    }

    public function addUser(User $user): void
    {
        $this->model()->addUser($user);
    }

    public function removeUser(User $user): void
    {
        $this->model()->removeUser($user);
    }
}
