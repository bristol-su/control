<?php

namespace BristolSU\ControlDB\Cache\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag as PositionTagRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class PositionTag implements PositionTagRepository
{

    /**
     * @var PositionTagRepository
     */
    private $positionTagRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(PositionTagRepository $positionTagRepository, Repository $cache)
    {
        $this->positionTagRepository = $positionTagRepository;
        $this->cache = $cache;
    }

    /**
     * Get all position tags
     *
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\Tags\PositionTag[]
     */
    public function all(): Collection
    {
        return $this->positionTagRepository->all();
    }

    /**
     * Get a tag by the full reference
     *
     * The full reference looks like 'tag_category_ref.tag_ref'
     *
     * @param string $reference
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
     */
    public function getTagByFullReference(string $reference): \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
    {
        return $this->cache->rememberForever(static::class . '@getTagByFullReference:' . $reference, function() use ($reference) {
            return $this->positionTagRepository->getTagByFullReference($reference);
        });
    }

    /**
     * Get a position tag by id
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
    {
        return $this->cache->rememberForever(static::class . '@getById:' . $id, function() use ($id) {
            return $this->positionTagRepository->getById($id);
        });
    }

    /**
     * Create a position tag
     *
     * @param string $name Name of the tag
     * @param string $description Description of the tag
     * @param string $reference Reference for the tag
     * @param int $tagCategoryId Category ID of the tag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
     */
    public function create(string $name, string $description, string $reference, int $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
    {
        return $this->positionTagRepository->create($name, $description, $reference, $tagCategoryId);
    }

    /**
     * Delete a position tag
     *
     * @param int $id ID of the tag to delete
     */
    public function delete(int $id): void
    {
        $this->positionTagRepository->delete($id);
    }

    /**
     * Get all tags through a tag category
     *
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory $positionTagCategory
     * @return Collection|PositionTagRepository Tags with the given position tag category
     */
    public function allThroughTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory $positionTagCategory): Collection
    {
        return $this->cache->rememberForever(static::class . '@allThroughTagCategory:' . $positionTagCategory->id(), function() use ($positionTagCategory) {
            return $this->positionTagRepository->allThroughTagCategory($positionTagCategory);
        });
    }

    /**
     * Update a position tag
     *
     * @param int $id
     * @param string $name Name of the tag
     * @param string $description Description of the tag
     * @param string $reference Reference for the tag
     * @param int $tagCategoryId Category ID of the tag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
     */
    public function update(int $id, string $name, string $description, string $reference, int $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
    {
        return $this->positionTagRepository->update($id, $name, $description, $reference, $tagCategoryId);
    }
}