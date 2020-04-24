<?php


namespace BristolSU\ControlDB\Contracts\Repositories;


use Illuminate\Support\Collection;

/**
 * Handle attributes of a user
 */
interface DataUser
{

    /**
     * Get a data user by ID
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\DataUser
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\DataUser;

    /**
     * Get a data user where the given attributes match, including additional attributes.
     *
     * @param array $attributes
     * @return \BristolSU\ControlDB\Contracts\Models\DataUser
     */
    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataUser;

    /**
     * Get all data users where the given attributes match, including additional attributes.
     *
     * @param array $attributes
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\DataUser[]
     */
    public function getAllWhere($attributes = []): Collection;
    
    /**
     * Create a data user with the given attributes
     * 
     * @param string|null $firstName First name of the user
     * @param string|null $lastName Last name of the user
     * @param string|null $email Email of the user
     * @param \DateTime|null $dob Date of birth of the user
     * @param string|null $preferredName Preferred name of the user
     * 
     * @return \BristolSU\ControlDB\Contracts\Models\DataUser
     */
    public function create(?string $firstName = null, ?string $lastName = null, ?string $email = null, ?\DateTime $dob = null, ?string $preferredName = null): \BristolSU\ControlDB\Contracts\Models\DataUser;

    /**
     * Update a data user
     * 
     * @param int $id
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $email
     * @param \DateTime|null $dob
     * @param string|null $preferredName
     * @return \BristolSU\ControlDB\Contracts\Models\DataUser
     */
    public function update(int $id, ?string $firstName = null, ?string $lastName = null, ?string $email = null, ?\DateTime $dob = null, ?string $preferredName = null): \BristolSU\ControlDB\Contracts\Models\DataUser;
}