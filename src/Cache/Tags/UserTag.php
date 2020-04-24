<?php

namespace BristolSU\ControlDB\Cache\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag as UserTagRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class UserTag implements UserTagRepository
{

    /**
     * @var UserTagRepository
     */
    private $userTagRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(UserTagRepository $userTagRepository, Repository $cache)
    {
        $this->userTagRepository = $userTagRepository;
        $this->cache = $cache;
    }

    /**
     * Get all user tags
     *
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\Tags\UserTag[]
     */
    public function all(): Collection
    {
        return $this->userTagRepository->all();
    }

    /**
     * Get a tag by the full reference
     *
     * The full reference looks like 'tag_category_ref.tag_ref'
     *
     * @param string $reference
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
     */
    public function getTagByFullReference(string $reference): \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
    {
        return $this->cache->rememberForever(static::class . '@getTagByFullReference:' . $reference, function() use ($reference) {
            return $this->userTagRepository->getTagByFullReference($reference);
        });
    }

    /**
     * Get a user tag by id
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
    {
        return $this->cache->rememberForever(static::class . '@getById:' . $id, function() use ($id) {
            return $this->userTagRepository->getById($id);
        });
    }

    /**
     * Create a user tag
     *
     * @param string $name Name of the tag
     * @param string $description Description of the tag
     * @param string $reference Reference for the tag
     * @param int $tagCategoryId Category ID of the tag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
     */
    public function create(string $name, string $description, string $reference, int $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
    {
        return $this->userTagRepository->create($name, $description, $reference, $tagCategoryId);
    }

    /**
     * Delete a user tag
     *
     * @param int $id ID of the tag to delete
     */
    public function delete(int $id): void
    {
        $this->userTagRepository->delete($id);
    }

    /**
     * Get all tags through a tag category
     *
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory $userTagCategory
     * @return Collection|UserTagRepository Tags with the given user tag category
     */
    public function allThroughTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory $userTagCategory): Collection
    {
        return $this->cache->rememberForever(static::class . '@allThroughTagCategory:' . $userTagCategory->id(), function() use ($userTagCategory) {
            return $this->userTagRepository->allThroughTagCategory($userTagCategory);
        });
    }

    /**
     * Update a user tag
     *
     * @param int $id
     * @param string $name Name of the tag
     * @param string $description Description of the tag
     * @param string $reference Reference for the tag
     * @param int $tagCategoryId Category ID of the tag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
     */
    public function update(int $id, string $name, string $description, string $reference, int $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
    {
        return $this->userTagRepository->update($id, $name, $description, $reference, $tagCategoryId);
    }
    
}