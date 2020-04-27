<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory as RoleTagCategoryModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTagCategory as RoleTagCategoryRepository;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Notifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use Illuminate\Support\Collection;

class RoleTagCategoryNotifier extends Notifier implements RoleTagCategoryRepository
{

    /**
     * @var RoleTagCategoryRepository
     */
    private $roleTagCategoryRepository;

    public function __construct(RoleTagCategoryRepository $roleTagCategoryRepository, ObserverStore $observerStore)
    {
        parent::__construct($observerStore, RoleTagCategoryRepository::class);
        $this->roleTagCategoryRepository = $roleTagCategoryRepository;
    }

    /**
     * Get all role tag categories
     *
     * @return Collection|RoleTagCategoryModel[]
     */
    public function all(): Collection
    {
        return $this->roleTagCategoryRepository->all();
    }

    /**
     * Get a tag category by the reference
     *
     * @param string $reference Reference of the tag
     * @return RoleTagCategoryModel
     */
    public function getByReference(string $reference): RoleTagCategoryModel
    {
        return $this->roleTagCategoryRepository->getByReference($reference);
    }

    /**
     * Get a role tag category by id
     *
     * @param int $id
     * @return RoleTagCategoryModel
     */
    public function getById(int $id): RoleTagCategoryModel
    {
        return $this->roleTagCategoryRepository->getById($id);
    }

    /**
     * Delete a role tag category
     *
     * @param int $id ID of the role tag category to delete
     */
    public function delete(int $id): void
    {
        $roleTagCategory = $this->getById($id);
        $this->roleTagCategoryRepository->delete($id);
        $this->notify('delete', $roleTagCategory);
    }

    /**
     * Create a role tag category
     *
     * @param string $name Name of the role tag category
     * @param string $description Description of the role tag category
     * @param string $reference Reference of the role tag category
     * @return RoleTagCategoryModel New role tag category
     */
    public function create(string $name, string $description, string $reference): RoleTagCategoryModel
    {
        $roleTagCategory = $this->roleTagCategoryRepository->create($name, $description, $reference);
        $this->notify('create', $roleTagCategory);
        return $roleTagCategory;
    }

    /**
     * Update a role tag category
     *
     * @param int $id
     * @param string $name Name of the role tag category
     * @param string $description Description of the role tag category
     * @param string $reference Reference of the role tag category
     * @return RoleTagCategoryModel New role tag category
     */
    public function update(int $id, string $name, string $description, string $reference): RoleTagCategoryModel
    {
        $oldRoleTagCategory = $this->getById($id);
        $newRoleTagCategory = $this->roleTagCategoryRepository->update($id, $name, $description, $reference);
        $this->notify('update', $oldRoleTagCategory, $newRoleTagCategory);
        return $newRoleTagCategory;
    }
}