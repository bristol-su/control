<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag as RoleTagRepository;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Notifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use Illuminate\Support\Collection;

class RoleTagNotifier extends Notifier implements RoleTagRepository
{

    /**
     * @var RoleTagRepository
     */
    private $roleTagRepository;

    public function __construct(RoleTagRepository $roleTagRepository, ObserverStore $observerStore)
    {
        parent::__construct($observerStore, RoleTagRepository::class);
        $this->roleTagRepository = $roleTagRepository;
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
        return $this->roleTagRepository->getTagByFullReference($reference);
    }

    /**
     * Get a role tag by id
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag
    {
        return $this->roleTagRepository->getById($id);
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
        $roleTag = $this->roleTagRepository->create($name, $description, $reference, $tagCategoryId);
        $this->notify('create', $roleTag);
        return $roleTag;
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
        $oldRoleTag = $this->getById($id);
        $newRoleTag = $this->roleTagRepository->update($id, $name, $description, $reference, $tagCategoryId);
        $this->notify('update', $oldRoleTag, $newRoleTag);
        return $newRoleTag;
    }

    /**
     * Delete a role tag
     *
     * @param int $id ID of the tag to delete
     */
    public function delete(int $id): void
    {
        $roleTag = $this->getById($id);
        $this->roleTagRepository->delete($id);
        $this->notify('delete', $roleTag);
    }

    /**
     * Get all tags through a tag category
     *
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory $roleTagCategory
     * @return Collection|RoleTagRepository Tags with the given role tag category
     */
    public function allThroughTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory $roleTagCategory): Collection
    {
        return $this->roleTagRepository->allThroughTagCategory($roleTagCategory);
    }
}