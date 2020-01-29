<?php


namespace BristolSU\ControlDB\Repositories;


class DataRole implements \BristolSU\ControlDB\Contracts\Repositories\DataRole
{

    /**
     * Get a data role by ID
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\DataRole
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\DataRole
    {
        return \BristolSU\ControlDB\Models\DataRole::findOrFail($id);
    }

    /**
     * Get a data role with the given attributes
     *
     * @param array $attributes
     * @return \BristolSU\ControlDB\Contracts\Models\DataRole
     */
    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataRole
    {
        return \BristolSU\ControlDB\Models\DataRole::where($attributes)->firstOrFail();
    }

    /**
     * Create a new data role
     *
     * @param string|null $roleName
     * @param string|null $email
     * @return \BristolSU\ControlDB\Contracts\Models\DataRole
     */
    public function create(?string $roleName = null, ?string $email = null): \BristolSU\ControlDB\Contracts\Models\DataRole
    {
        return \BristolSU\ControlDB\Models\DataRole::create([
            'role_name' => $roleName,
            'email' => $email,
        ]);
    }
}