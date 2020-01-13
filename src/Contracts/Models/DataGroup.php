<?php

namespace BristolSU\ControlDB\Contracts\Models;

interface DataGroup
{

    public function setName(?string $name): void;

    public function setEmail(?string $email): void;
    
    public function name(): ?string;

    public function email(): ?string;

    public function id();

}