<?php

namespace BristolSU\ControlDB\Contracts\Repositories;

interface DataPosition
{
    public function getById($id): \BristolSU\ControlDB\Contracts\Models\DataPosition;

    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataPosition;
    
    public function create(?string $name = null, ?string $description = null): \BristolSU\ControlDB\Contracts\Models\DataPosition;
}