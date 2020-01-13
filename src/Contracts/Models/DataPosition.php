<?php

namespace BristolSU\ControlDB\Contracts\Models;

interface DataPosition
{

    public function setName(?string $name): void;

    public function setDescription(?string $description): void;

    public function name(): ?string;

    public function description(): ?string;

    public function id();

}