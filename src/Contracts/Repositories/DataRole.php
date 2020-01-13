<?php

namespace BristolSU\ControlDB\Contracts\Repositories;

interface DataRole
{
    public function getById($id): \BristolSU\ControlDB\Contracts\Models\DataRole;

    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataRole;
    
    public function create(?string $positionName = null, ?string $email = null): \BristolSU\ControlDB\Contracts\Models\DataRole;
}