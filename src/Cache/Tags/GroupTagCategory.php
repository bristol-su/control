<?php

namespace BristolSU\ControlDB\Cache\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory as GroupTagCategoryModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTagCategory as GroupTagCategoryRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class GroupTagCategory implements GroupTagCategoryRepository
{

    /**
     * @var GroupTagCategoryRepository
     */
    private $groupTagCategoryRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(GroupTagCategoryRepository $groupTagCategoryRepository, Repository $cache)
    {
        $this->groupTagCategoryRepository = $groupTagCategoryRepository;
        $this->cache = $cache;
    }

    /**
     * Get all group tag categories
     *
     * @return Collection|GroupTagCategoryModel[]
     */
    public function all(): Collection
    {
        return $this->groupTagCategoryRepository->all();
    }

    /**
     * Get a tag category by the reference
     *
     * @param string $reference Reference of the tag
     * @return GroupTagCategoryModel
     */
    public function getByReference(string $reference): GroupTagCategoryModel
    {
        return $this->cache->rememberForever(static::class . '@getByReference:' . $reference, function() use ($reference) {
            return $this->groupTagCategoryRepository->getByReference($reference);
        });
    }

    /**
     * Get a group tag category by id
     *
     * @param int $id
     * @return GroupTagCategoryModel
     */
    public function getById(int $id): GroupTagCategoryModel
    {
        return $this->cache->rememberForever(static::class . '@getById:' . $id, function() use ($id) {
            return $this->groupTagCategoryRepository->getById($id);
        });  
    }

    /**
     * Delete a group tag category
     *
     * @param int $id ID of the group tag category to delete
     */
    public function delete(int $id): void
    {
        $this->groupTagCategoryRepository->delete($id);
    }

    /**
     * Create a group tag category
     *
     * @param string $name Name of the group tag category
     * @param string $description Description of the group tag category
     * @param string $reference Reference of the group tag category
     * @return GroupTagCategoryModel New group tag category
     */
    public function create(string $name, string $description, string $reference): GroupTagCategoryModel
    {
        return $this->groupTagCategoryRepository->create($name, $description, $reference);
    }

    /**
     * Update a group tag category
     *
     * @param int $id
     * @param string $name Name of the group tag category
     * @param string $description Description of the group tag category
     * @param string $reference Reference of the group tag category
     * @return GroupTagCategoryModel Updated group tag category
     */
    public function update(int $id, string $name, string $description, string $reference): GroupTagCategoryModel
    {
        return $this->groupTagCategoryRepository->update($id, $name, $description, $reference);
    }
}