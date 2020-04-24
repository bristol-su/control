<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory as UserTagCategoryModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTagCategory as UserTagCategoryRepository;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Notifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use Illuminate\Support\Collection;

class UserTagCategoryNotifier extends Notifier implements UserTagCategoryRepository
{

    /**
     * @var UserTagCategoryRepository
     */
    private $userTagCategoryRepository;

    public function __construct(UserTagCategoryRepository $userTagCategoryRepository, ObserverStore $observerStore)
    {
        parent::__construct($observerStore, UserTagCategoryRepository::class);
        $this->userTagCategoryRepository = $userTagCategoryRepository;
    }

    /**
     * Get all user tag categories
     *
     * @return Collection|UserTagCategoryModel[]
     */
    public function all(): Collection
    {
        return $this->userTagCategoryRepository->all();
    }

    /**
     * Get a tag category by the reference
     *
     * @param string $reference Reference of the tag
     * @return UserTagCategoryModel
     */
    public function getByReference(string $reference): UserTagCategoryModel
    {
        return $this->userTagCategoryRepository->getByReference($reference);
    }

    /**
     * Get a user tag category by id
     *
     * @param int $id
     * @return UserTagCategoryModel
     */
    public function getById(int $id): UserTagCategoryModel
    {
        return $this->userTagCategoryRepository->getById($id);
    }

    /**
     * Delete a user tag category
     *
     * @param int $id ID of the user tag category to delete
     */
    public function delete(int $id): void
    {
        $userTagCategory = $this->getById($id);
        $this->userTagCategoryRepository->delete($id);
        $this->notify('delete', $userTagCategory);
    }

    /**
     * Create a user tag category
     *
     * @param string $name Name of the user tag category
     * @param string $description Description of the user tag category
     * @param string $reference Reference of the user tag category
     * @return UserTagCategoryModel New user tag category
     */
    public function create(string $name, string $description, string $reference): UserTagCategoryModel
    {
        $userTagCategory = $this->userTagCategoryRepository->create($name, $description, $reference);
        $this->notify('create', $userTagCategory);
        return $userTagCategory;
    }

    /**
     * Update a user tag category
     *
     * @param int $id
     * @param string $name Name of the user tag category
     * @param string $description Description of the user tag category
     * @param string $reference Reference of the user tag category
     * @return UserTagCategoryModel New user tag category
     */
    public function update(int $id, string $name, string $description, string $reference): UserTagCategoryModel
    {
        $oldUserTagCategory = $this->getById($id);
        $newUserTagCategory = $this->userTagCategoryRepository->update($id, $name, $description, $reference);
        $this->notify('update', $oldUserTagCategory, $newUserTagCategory);
        return $newUserTagCategory;
    }
}