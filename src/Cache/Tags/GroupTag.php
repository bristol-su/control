<?php

namespace BristolSU\ControlDB\Cache\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTag as GroupTagRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class GroupTag implements GroupTagRepository
{

    /**
     * @var GroupTagRepository
     */
    private $groupTagRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(GroupTagRepository $groupTagRepository, Repository $cache)
    {
        $this->groupTagRepository = $groupTagRepository;
        $this->cache = $cache;
    }

    /**
     * Get all group tags
     *
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\Tags\GroupTag[]
     */
    public function all(): Collection
    {
        return $this->groupTagRepository->all();
    }

    /**
     * Get a tag by the full reference
     *
     * The full reference looks like 'tag_category_ref.tag_ref'
     *
     * @param string $reference
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
     */
    public function getTagByFullReference(string $reference): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
    {
        return $this->cache->rememberForever(static::class . '@getTagByFullReference:' . $reference, function() use ($reference) {
            return $this->groupTagRepository->getTagByFullReference($reference);
        });
    }

    /**
     * Get a group tag by id
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
    {
        return $this->cache->rememberForever(static::class . '@getById:' . $id, function() use ($id) {
            return $this->groupTagRepository->getById($id);
        });
    }

    /**
     * Create a group tag
     *
     * @param string $name Name of the tag
     * @param string $description Description of the tag
     * @param string $reference Reference for the tag
     * @param int $tagCategoryId Category ID of the tag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
     */
    public function create(string $name, string $description, string $reference, int $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
    {
        return $this->groupTagRepository->create($name, $description, $reference, $tagCategoryId);
    }

    /**
     * Delete a group tag
     *
     * @param int $id ID of the tag to delete
     */
    public function delete(int $id): void
    {
        $this->groupTagRepository->delete($id);
    }

    /**
     * Get all tags through a tag category
     *
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory $groupTagCategory
     * @return Collection|GroupTagRepository Tags with the given group tag category
     */
    public function allThroughTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory $groupTagCategory): Collection
    {
        return $this->cache->rememberForever(static::class . '@allThroughTagCategory:' . $groupTagCategory->id(), function() use ($groupTagCategory) {
            return $this->groupTagRepository->allThroughTagCategory($groupTagCategory);
        });
    }

    /**
     * Update a group tag
     *
     * @param int $id
     * @param string $name Name of the tag
     * @param string $description Description of the tag
     * @param string $reference Reference for the tag
     * @param int $tagCategoryId Category ID of the tag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
     */
    public function update(int $id, string $name, string $description, string $reference, int $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
    {
        return $this->groupTagRepository->update($id, $name, $description, $reference, $tagCategoryId);
    }
}