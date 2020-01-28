<?php

namespace BristolSU\ControlDB\Contracts\Models;

use BristolSU\ControlDB\AdditionalProperties\ImplementsAdditionalProperties;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

interface DataRole extends ImplementsAdditionalProperties, Arrayable, Jsonable
{

    public function setRoleName(?string $roleName): void;

    public function setEmail(?string $email): void;

    public function roleName(): ?string;

    public function email(): ?string;

    public function id(): int;

    public function role(): ?Role;


}