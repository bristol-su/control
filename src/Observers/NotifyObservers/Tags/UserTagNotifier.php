<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag as UserTagRepository;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Notifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use Illuminate\Support\Collection;

class UserTagNotifier extends Notifier implements UserTagRepository
{

    /**
     * @var UserTagRepository
     */
    private $userTagRepository;

    public function __construct(UserTagRepository $userTagRepository, ObserverStore $observerStore)
    {
        parent::__construct($observerStore, UserTagRepository::class);
        $this->userTagRepository = $userTagRepository;
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
        return $this->userTagRepository->getTagByFullReference($reference);
    }

    /**
     * Get a user tag by id
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
    {
        return $this->userTagRepository->getById($id);
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
        $userTag = $this->userTagRepository->create($name, $description, $reference, $tagCategoryId);
        $this->notify('create', $userTag);
        return $userTag;
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
        $oldUserTag = $this->getById($id);
        $newUserTag = $this->userTagRepository->update($id, $name, $description, $reference, $tagCategoryId);
        $this->notify('update', $oldUserTag, $newUserTag);
        return $newUserTag;
    }

    /**
     * Delete a user tag
     *
     * @param int $id ID of the tag to delete
     */
    public function delete(int $id): void
    {
        $userTag = $this->getById($id);
        $this->userTagRepository->delete($id);
        $this->notify('delete', $userTag);
    }

    /**
     * Get all tags through a tag category
     *
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory $userTagCategory
     * @return Collection|UserTagRepository Tags with the given user tag category
     */
    public function allThroughTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory $userTagCategory): Collection
    {
        return $this->userTagRepository->allThroughTagCategory($userTagCategory);
    }
}