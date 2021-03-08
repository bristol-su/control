<?php

namespace BristolSU\ControlDB\Models\Dummy;

use BristolSU\ControlDB\Contracts\Models\DataRole;
use BristolSU\ControlDB\Contracts\Models\Role;

class DataRoleDummy implements DataRole
{
    private ?int $id;

    private ?string $roleName = 'N/A';

    private ?string $email = 'N/A';

    public function __construct(int $id = null)
    {
        $this->id = $id;
    }

    public function toArray()
    {
        return [
            'id' => $this->id(),
            'roleN_nme' => $this->roleName(),
            'email' => $this->email()
        ];
    }

    public function id(): int
    {
        return $this->id ?? 0;
    }

    public function roleName(): ?string
    {
        return $this->roleName;
    }

    public function email(): ?string
    {
        return $this->email;
    }

    public function setRoleName(?string $roleName): void
    {
        $this->roleName = $roleName;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public static function addProperty(string $key): void
    {
    }

    public static function getAdditionalAttributes(): array
    {
    }

    public function getAdditionalAttribute(string $key)
    {
    }

    public function setAdditionalAttribute(string $key, $value)
    {
    }

    public function saveAdditionalAttribute(string $key, $value)
    {
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }

    public function role(): ?Role
    {
        return null;
    }
}