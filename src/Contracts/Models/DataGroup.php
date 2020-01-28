<?php

namespace BristolSU\ControlDB\Contracts\Models;

use BristolSU\ControlDB\AdditionalProperties\ImplementsAdditionalProperties;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

interface DataGroup extends ImplementsAdditionalProperties, Arrayable, Jsonable
{

    public function setName(?string $name): void;

    public function setEmail(?string $email): void;
    
    public function name(): ?string;

    public function email(): ?string;

    public function id(): int;

    public function group(): ?Group;

}