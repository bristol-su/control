<?php

namespace BristolSU\ControlDB\Cache\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag as RoleTagRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class RoleTag implements RoleTagRepository
{

    /**
     * @var RoleTagRepository
     */
    private $roleTagRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(RoleTagRepository $roleTagRepository, Repository $cache)
    {
        $this->roleTagRepository = $roleTagRepository;
        $this->cache = $cache;
    }

    /**
     * Get all role tags
     *
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\Tags\RoleTag[]
     */
    public function all(): Collection
    {
        return $this->roleTagRepository->all();
    }

    /**
     * Get a tag by the full reference
     *
     * The full reference looks like 'tag_category_ref.tag_ref'
     *
     * @param string $reference
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag
     */
    public function getTagByFullReference(string $reference): \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag
    {
        return $this->cache->rememberForever(static::class . '@getTagByFullReference:' . $reference, function() use ($reference) {
            return $this->roleTagRepository->getTagByFullReference($reference);
        });
    }

    /**
     * Get a role tag by id
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag
    {
        return $this->cache->rememberForever(static::class . '@getById:' . $id, function() use ($id) {
            return $this->roleTagRepository->getById($id);
        });
    }

    /**
     * Create a role tag
     *
     * @param string $name Name of the tag
     * @param string $description Description of the tag
     * @param string $reference Reference for the tag
     * @param int $tagCategoryId Category ID of the tag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag
     */
    public function create(string $name, string $description, string $reference, int $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag
    {
        return $this->roleTagRepository->create($name, $description, $reference, $tagCategoryId);
    }

    /**
     * Delete a role tag
     *
     * @param int $id ID of the tag to delete
     */
    public function delete(int $id): void
    {
        $this->roleTagRepository->delete($id);
    }

    /**
     * Get all tags through a tag category
     *
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory $roleTagCategory
     * @return Collection|RoleTagRepository Tags with the given role tag category
     */
    public function allThroughTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory $roleTagCategory): Collection
    {
        return $this->cache->rememberForever(static::class . '@allThroughTagCategory:' . $roleTagCategory->id(), function() use ($roleTagCategory) {
            return $this->roleTagRepository->allThroughTagCategory($roleTagCategory);
        });
    }

    /**
     * Update a role tag
     *
     * @param int $id
     * @param string $name Name of the tag
     * @param string $description Description of the tag
     * @param string $reference Reference for the tag
     * @param int $tagCategoryId Category ID of the tag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag
     */
    public function update(int $id, string $name, string $description, string $reference, int $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag
    {
        return $this->roleTagRepository->update($id, $name, $description, $reference, $tagCategoryId);
    }
}