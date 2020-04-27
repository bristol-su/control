<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers;

use BristolSU\ControlDB\Contracts\Models\User as UserModel;
use BristolSU\ControlDB\Contracts\Repositories\User as UserRepository;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Notifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use Illuminate\Support\Collection;

class UserNotifier extends Notifier implements UserRepository
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository, ObserverStore $observerStore)
    {
        parent::__construct($observerStore, UserRepository::class);
        $this->userRepository = $userRepository;
    }

    /**
     * Get a user by ID
     *
     * @param int $id ID of the user
     * @return UserModel
     */
    public function getById(int $id): UserModel
    {
        return $this->userRepository->getById($id);
    }

    /**
     * Get a user by its data provider ID
     *
     * @param int $dataProviderId
     * @return UserModel
     */
    public function getByDataProviderId(int $dataProviderId): UserModel
    {
        return $this->userRepository->getByDataProviderId($dataProviderId);
    }

    /**
     * Get all users
     *
     * @return Collection|UserModel[]
     */
    public function all(): Collection
    {
        return $this->userRepository->all();
    }

    /**
     * Create a new user
     *
     * @param int $dataProviderId
     * @return UserModel
     */
    public function create(int $dataProviderId): UserModel
    {
        $userModel = $this->userRepository->create($dataProviderId);
        $this->notify('create', $userModel);
        return $userModel;
    }

    /**
     * Delete a user by ID
     *
     * @param int $id
     */
    public function delete(int $id): void
    {
        $userModel = $this->getById($id);
        $this->userRepository->delete($id);
        $this->notify('delete', $userModel);
    }

    /**
     * Update the user model
     *
     * @param int $id
     * @param int $dataProviderId New data provider ID
     * @return UserModel
     */
    public function update(int $id, int $dataProviderId): UserModel
    {
        $oldUserModel = $this->getById($id);
        $newUserModel = $this->userRepository->update($id, $dataProviderId);
        $this->notify('update', $oldUserModel, $newUserModel);
        return $newUserModel;
    }

    /**
     * Paginate through all the users
     *
     * @param int $page The page number to return
     * @param int $perPage The number of results to return per page
     *
     * @return Collection|UserModel[]
     */
    public function paginate(int $page, int $perPage): Collection
    {
        return $this->userRepository->paginate($page, $perPage);
    }

    /**
     * Get the number of users
     *
     * @return int
     */
    public function count(): int
    {
        return $this->userRepository->count();
    }
}