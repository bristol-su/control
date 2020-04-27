<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory as GroupTagCategoryModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTagCategory as GroupTagCategoryRepository;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Notifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use Illuminate\Support\Collection;

class GroupTagCategoryNotifier extends Notifier implements GroupTagCategoryRepository
{

    /**
     * @var GroupTagCategoryRepository
     */
    private $groupTagCategoryRepository;

    public function __construct(GroupTagCategoryRepository $groupTagCategoryRepository, ObserverStore $observerStore)
    {
        parent::__construct($observerStore, GroupTagCategoryRepository::class);
        $this->groupTagCategoryRepository = $groupTagCategoryRepository;
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
        return $this->groupTagCategoryRepository->getByReference($reference);
    }

    /**
     * Get a group tag category by id
     *
     * @param int $id
     * @return GroupTagCategoryModel
     */
    public function getById(int $id): GroupTagCategoryModel
    {
        return $this->groupTagCategoryRepository->getById($id);
    }

    /**
     * Delete a group tag category
     *
     * @param int $id ID of the group tag category to delete
     */
    public function delete(int $id): void
    {
        $groupTagCategory = $this->getById($id);
        $this->groupTagCategoryRepository->delete($id);
        $this->notify('delete', $groupTagCategory);
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
        $groupTagCategory = $this->groupTagCategoryRepository->create($name, $description, $reference);
        $this->notify('create', $groupTagCategory);
        return $groupTagCategory;
    }

    /**
     * Update a group tag category
     *
     * @param int $id
     * @param string $name Name of the group tag category
     * @param string $description Description of the group tag category
     * @param string $reference Reference of the group tag category
     * @return GroupTagCategoryModel New group tag category
     */
    public function update(int $id, string $name, string $description, string $reference): GroupTagCategoryModel
    {
        $oldGroupTagCategory = $this->getById($id);
        $newGroupTagCategory = $this->groupTagCategoryRepository->update($id, $name, $description, $reference);
        $this->notify('update', $oldGroupTagCategory, $newGroupTagCategory);
        return $newGroupTagCategory;
    }
}