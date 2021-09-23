<?php

namespace BristolSU\ControlDB\Models\Dummy;

use BristolSU\ControlDB\Contracts\Models\DataPosition;
use BristolSU\ControlDB\Contracts\Models\Position;

class DataPositionDummy implements DataPosition
{
    private ?int $id;

    private ?string $name = 'N/A';

    private ?string $description = 'N/A';

    public function __construct(int $id = null)
    {
        $this->id = $id;
    }

    public function toArray()
    {
        return [
            'id' => $this->id(),
            'name' => $this->name(),
            'description' => $this->description()
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

    public function description(): ?string
    {
        return $this->description;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
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

    public function position(): ?Position
    {
        return null;
    }
}