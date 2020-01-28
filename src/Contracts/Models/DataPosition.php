<?php

namespace BristolSU\ControlDB\Contracts\Models;

use BristolSU\ControlDB\AdditionalProperties\ImplementsAdditionalProperties;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

interface DataPosition extends ImplementsAdditionalProperties, Arrayable, Jsonable
{

    public function setName(?string $name): void;

    public function setDescription(?string $description): void;

    public function name(): ?string;

    public function description(): ?string;

    public function id(): int;

    public function position(): ?Position;

}