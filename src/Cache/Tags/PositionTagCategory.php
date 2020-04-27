<?php

namespace BristolSU\ControlDB\Cache\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory as PositionTagCategoryModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTagCategory as PositionTagCategoryRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class PositionTagCategory implements PositionTagCategoryRepository
{

    /**
     * @var PositionTagCategoryRepository
     */
    private $positionTagCategoryRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(PositionTagCategoryRepository $positionTagCategoryRepository, Repository $cache)
    {
        $this->positionTagCategoryRepository = $positionTagCategoryRepository;
        $this->cache = $cache;
    }

    /**
     * Get all position tag categories
     *
     * @return Collection|PositionTagCategoryModel[]
     */
    public function all(): Collection
    {
        return $this->positionTagCategoryRepository->all();
    }

    /**
     * Get a tag category by the reference
     *
     * @param string $reference Reference of the tag
     * @return PositionTagCategoryModel
     */
    public function getByReference(string $reference): PositionTagCategoryModel
    {
        return $this->cache->rememberForever(static::class . '@getByReference:' . $reference, function() use ($reference) {
            return $this->positionTagCategoryRepository->getByReference($reference);
        });
    }

    /**
     * Get a position tag category by id
     *
     * @param int $id
     * @return PositionTagCategoryModel
     */
    public function getById(int $id): PositionTagCategoryModel
    {
        return $this->cache->rememberForever(static::class . '@getById:' . $id, function() use ($id) {
            return $this->positionTagCategoryRepository->getById($id);
        });  
    }

    /**
     * Delete a position tag category
     *
     * @param int $id ID of the position tag category to delete
     */
    public function delete(int $id): void
    {
        $this->positionTagCategoryRepository->delete($id);
    }

    /**
     * Create a position tag category
     *
     * @param string $name Name of the position tag category
     * @param string $description Description of the position tag category
     * @param string $reference Reference of the position tag category
     * @return PositionTagCategoryModel New position tag category
     */
    public function create(string $name, string $description, string $reference): PositionTagCategoryModel
    {
        return $this->positionTagCategoryRepository->create($name, $description, $reference);
    }

    /**
     * Update a position tag category
     *
     * @param int $id
     * @param string $name Name of the position tag category
     * @param string $description Description of the position tag category
     * @param string $reference Reference of the position tag category
     * @return PositionTagCategoryModel Updated position tag category
     */
    public function update(int $id, string $name, string $description, string $reference): PositionTagCategoryModel
    {
        return $this->positionTagCategoryRepository->update($id, $name, $description, $reference);
    }
}