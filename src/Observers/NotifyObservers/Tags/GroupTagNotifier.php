<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTag as GroupTagRepository;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Notifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use Illuminate\Support\Collection;

class GroupTagNotifier extends Notifier implements GroupTagRepository
{

    /**
     * @var GroupTagRepository
     */
    private $groupTagRepository;

    public function __construct(GroupTagRepository $groupTagRepository, ObserverStore $observerStore)
    {
        parent::__construct($observerStore, GroupTagRepository::class);
        $this->groupTagRepository = $groupTagRepository;
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
        return $this->groupTagRepository->getTagByFullReference($reference);
    }

    /**
     * Get a group tag by id
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
    {
        return $this->groupTagRepository->getById($id);
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
        $groupTag = $this->groupTagRepository->create($name, $description, $reference, $tagCategoryId);
        $this->notify('create', $groupTag);
        return $groupTag;
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
        $oldGroupTag = $this->getById($id);
        $newGroupTag = $this->groupTagRepository->update($id, $name, $description, $reference, $tagCategoryId);
        $this->notify('update', $oldGroupTag, $newGroupTag);
        return $newGroupTag;
    }

    /**
     * Delete a group tag
     *
     * @param int $id ID of the tag to delete
     */
    public function delete(int $id): void
    {
        $groupTag = $this->getById($id);
        $this->groupTagRepository->delete($id);
        $this->notify('delete', $groupTag);
    }

    /**
     * Get all tags through a tag category
     *
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory $groupTagCategory
     * @return Collection|GroupTagRepository Tags with the given group tag category
     */
    public function allThroughTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory $groupTagCategory): Collection
    {
        return $this->groupTagRepository->allThroughTagCategory($groupTagCategory);
    }
}