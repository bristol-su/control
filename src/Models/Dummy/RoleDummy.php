<?php

namespace BristolSU\ControlDB\Models\Dummy;

use BristolSU\ControlDB\Contracts\Models\DataRole;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Traits\RoleTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class RoleDummy implements Role
{

    private ?int $id;

    private ?int $positionId;

    private ?int $groupId;

    public function __construct(int $id = null)
    {
        $this->id = $id;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function dataProviderId(): int
    {
        return $this->id ?? 0;
    }

    public function setDataProviderId(int $dataProviderId): void
    {
        $this->dataProviderId = $dataProviderId;
    }

    public function data(): DataRole
    {
        if($this->dataProviderId() !== null) {
            try {
                return app(\BristolSU\ControlDB\Contracts\Repositories\DataRole::class)
                    ->getById($this->dataProviderId());
            } catch (ModelNotFoundException $e) {
                return new DataRoleDummy($this->dataProviderId());
            }
        }
        return new DataRoleDummy();
    }

    public function toArray()
    {
        return [
            'id' => $this->id(),
            'data_provider_id' => $this->dataProviderId(),
            'position_id' => $this->positionId(),
            'group_id' => $this->groupId(),
            'data' => $this->data()->toArray()
        ];
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }

    public function positionId(): int
    {
        return $this->positionId ?? 0;
    }

    public function groupId(): int
    {
        return $this->groupId ?? 0;
    }

    public function setGroupId(int $groupId): void
    {
        $this->groupId = $groupId;
    }

    public function setPositionId(int $positionId): void
    {
        $this->positionId = $positionId;
    }

    public function position(): Position
    {
        return new PositionDummy($this->positionId());
    }

    public function group(): Group
    {
        return new GroupDummy($this->groupId());
    }

    public function users(): Collection
    {
        return new Collection();
    }

    public function tags(): Collection
    {
        return new Collection();
    }

    public function addTag(RoleTag $roleTag): void
    {
    }

    public function removeTag(RoleTag $roleTag): void
    {
    }

    public function addUser(User $user): void
    {
    }

    public function removeUser(User $user): void
    {
    }
}
