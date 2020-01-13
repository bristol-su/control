<?php

namespace BristolSU\ControlDB\Contracts\Repositories;

interface DataGroup
{
    public function getById($id): \BristolSU\ControlDB\Contracts\Models\DataGroup;

    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataGroup;
    
    public function create(?string $name = null, ?string $email = null): \BristolSU\ControlDB\Contracts\Models\DataGroup;
}