<?php

namespace BristolSU\ControlDB\Cache\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory as UserTagCategoryModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTagCategory as UserTagCategoryRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class UserTagCategory implements UserTagCategoryRepository
{

    /**
     * @var UserTagCategoryRepository
     */
    private $userTagCategoryRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(UserTagCategoryRepository $userTagCategoryRepository, Repository $cache)
    {
        $this->userTagCategoryRepository = $userTagCategoryRepository;
        $this->cache = $cache;
    }

    /**
     * Get all user tag categories
     *
     * @return Collection|UserTagCategoryModel[]
     */
    public function all(): Collection
    {
        return $this->userTagCategoryRepository->all();
    }

    /**
     * Get a tag category by the reference
     *
     * @param string $reference Reference of the tag
     * @return UserTagCategoryModel
     */
    public function getByReference(string $reference): UserTagCategoryModel
    {
        return $this->cache->rememberForever(static::class . '@getByReference:' . $reference, function() use ($reference) {
            return $this->userTagCategoryRepository->getByReference($reference);
        });
    }

    /**
     * Get a user tag category by id
     *
     * @param int $id
     * @return UserTagCategoryModel
     */
    public function getById(int $id): UserTagCategoryModel
    {
        return $this->cache->rememberForever(static::class . '@getById:' . $id, function() use ($id) {
            return $this->userTagCategoryRepository->getById($id);
        });  
    }

    /**
     * Delete a user tag category
     *
     * @param int $id ID of the user tag category to delete
     */
    public function delete(int $id): void
    {
        $this->userTagCategoryRepository->delete($id);
    }

    /**
     * Create a user tag category
     *
     * @param string $name Name of the user tag category
     * @param string $description Description of the user tag category
     * @param string $reference Reference of the user tag category
     * @return UserTagCategoryModel New user tag category
     */
    public function create(string $name, string $description, string $reference): UserTagCategoryModel
    {
        return $this->userTagCategoryRepository->create($name, $description, $reference);
    }

    /**
     * Update a user tag category
     *
     * @param int $id
     * @param string $name Name of the user tag category
     * @param string $description Description of the user tag category
     * @param string $reference Reference of the user tag category
     * @return UserTagCategoryModel Updated user tag category
     */
    public function update(int $id, string $name, string $description, string $reference): UserTagCategoryModel
    {
        return $this->userTagCategoryRepository->update($id, $name, $description, $reference);
    }
}