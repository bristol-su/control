<?php


namespace BristolSU\ControlDB\Contracts\Repositories;


interface DataUser
{
    public function getById($id): \BristolSU\ControlDB\Contracts\Models\DataUser;

    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataUser;
    
    public function create(?string $firstName = null, ?string $lastName = null, ?string $email = null, ?\DateTime $dob = null, ?string $preferredName = null): \BristolSU\ControlDB\Contracts\Models\DataUser;
}