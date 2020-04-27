<?php

namespace BristolSU\ControlDB\Cache;

use BristolSU\ControlDB\Contracts\Repositories\DataUser as DataUserRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class DataUser implements DataUserRepository
{

    /**
     * @var DataUserRepository
     */
    private $dataUserRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(DataUserRepository $dataUserRepository, Repository $cache)
    {
        $this->dataUserRepository = $dataUserRepository;
        $this->cache = $cache;
    }

    /**
     * Get a data user by ID
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\DataUser
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\DataUser
    {
        return $this->cache->rememberForever(static::class . '@getById:' . $id, function() use ($id) {
            return $this->dataUserRepository->getById($id);
        });
    }

    /**
     * Get a data user where the given attributes match, including additional attributes.
     *
     * @param array $attributes
     * @return \BristolSU\ControlDB\Contracts\Models\DataUser
     */
    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataUser
    {
        return $this->dataUserRepository->getWhere($attributes);
    }
    
    /**
     * Get all data users where the given attributes match, including additional attributes.
     *
     * @param array $attributes
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\DataUser[]
     */
    public function getAllWhere($attributes = []): Collection
    {
        return $this->dataUserRepository->getAllWhere($attributes);
    }

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
    public function create(?string $firstName = null, ?string $lastName = null, ?string $email = null, ?\DateTime $dob = null, ?string $preferredName = null): \BristolSU\ControlDB\Contracts\Models\DataUser
    {
        return $this->dataUserRepository->create($firstName, $lastName, $email, $dob, $preferredName);
    }

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
    public function update(int $id, ?string $firstName = null, ?string $lastName = null, ?string $email = null, ?\DateTime $dob = null, ?string $preferredName = null): \BristolSU\ControlDB\Contracts\Models\DataUser
    {
        return $this->dataUserRepository->update($id, $firstName, $lastName, $email, $dob, $preferredName);
    }
}