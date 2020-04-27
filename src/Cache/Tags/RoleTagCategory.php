<?php

namespace BristolSU\ControlDB\Cache\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory as RoleTagCategoryModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTagCategory as RoleTagCategoryRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class RoleTagCategory implements RoleTagCategoryRepository
{

    /**
     * @var RoleTagCategoryRepository
     */
    private $roleTagCategoryRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(RoleTagCategoryRepository $roleTagCategoryRepository, Repository $cache)
    {
        $this->roleTagCategoryRepository = $roleTagCategoryRepository;
        $this->cache = $cache;
    }

    /**
     * Get all role tag categories
     *
     * @return Collection|RoleTagCategoryModel[]
     */
    public function all(): Collection
    {
        return $this->roleTagCategoryRepository->all();
    }

    /**
     * Get a tag category by the reference
     *
     * @param string $reference Reference of the tag
     * @return RoleTagCategoryModel
     */
    public function getByReference(string $reference): RoleTagCategoryModel
    {
        return $this->cache->rememberForever(static::class . '@getByReference:' . $reference, function() use ($reference) {
            return $this->roleTagCategoryRepository->getByReference($reference);
        });
    }

    /**
     * Get a role tag category by id
     *
     * @param int $id
     * @return RoleTagCategoryModel
     */
    public function getById(int $id): RoleTagCategoryModel
    {
        return $this->cache->rememberForever(static::class . '@getById:' . $id, function() use ($id) {
            return $this->roleTagCategoryRepository->getById($id);
        });  
    }

    /**
     * Delete a role tag category
     *
     * @param int $id ID of the role tag category to delete
     */
    public function delete(int $id): void
    {
        $this->roleTagCategoryRepository->delete($id);
    }

    /**
     * Create a role tag category
     *
     * @param string $name Name of the role tag category
     * @param string $description Description of the role tag category
     * @param string $reference Reference of the role tag category
     * @return RoleTagCategoryModel New role tag category
     */
    public function create(string $name, string $description, string $reference): RoleTagCategoryModel
    {
        return $this->roleTagCategoryRepository->create($name, $description, $reference);
    }

    /**
     * Update a role tag category
     *
     * @param int $id
     * @param string $name Name of the role tag category
     * @param string $description Description of the role tag category
     * @param string $reference Reference of the role tag category
     * @return RoleTagCategoryModel Updated role tag category
     */
    public function update(int $id, string $name, string $description, string $reference): RoleTagCategoryModel
    {
        return $this->roleTagCategoryRepository->update($id, $name, $description, $reference);
    }
}