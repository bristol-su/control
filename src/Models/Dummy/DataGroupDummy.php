<?php

namespace BristolSU\ControlDB\Models\Dummy;

use BristolSU\ControlDB\Contracts\Models\DataGroup;
use BristolSU\ControlDB\Contracts\Models\Group;

class DataGroupDummy implements DataGroup
{
    private ?int $id;

    private ?string $name = 'N/A';

    private ?string $email = 'N/A';

    public function __construct(int $id = null)
    {
        $this->id = $id;
    }

    public function toArray()
    {
        return [
            'id' => $this->id(),
            'name' => $this->name(),
            'email' => $this->email()
        ];
    }

    public function id(): int
    {
        return $this->id ?? 0;
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function email(): ?string
    {
        return $this->email;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
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

    public function group(): ?Group
    {
        return null;
    }
}