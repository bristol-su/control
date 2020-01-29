<?php


namespace BristolSU\ControlDB\Repositories;


class DataUser implements \BristolSU\ControlDB\Contracts\Repositories\DataUser
{

    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\DataUser
    {
        return \BristolSU\ControlDB\Models\DataUser::findOrFail($id);
    }


    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataUser
    {
        return \BristolSU\ControlDB\Models\DataUser::where($attributes)->firstOrFail();
    }

    public function create(?string $firstName = null, ?string $lastName = null, ?string $email = null, ?\DateTime $dob = null, ?string $preferredName = null): \BristolSU\ControlDB\Contracts\Models\DataUser
    {
        return \BristolSU\ControlDB\Models\DataUser::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'dob' => $dob,
            'preferred_name' => $preferredName
        ]);
    }
}