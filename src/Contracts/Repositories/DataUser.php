<?php


namespace BristolSU\ControlDB\Contracts\Repositories;


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
}