<?php

namespace BristolSU\ControlDB\Contracts\Models;

interface DataRole
{

    public function setPositionName(?string $positionName): void;

    public function setEmail(?string $email): void;

    public function positionName(): ?string;

    public function email(): ?string;

    public function id();

}