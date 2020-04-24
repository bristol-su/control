<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers\Pivots;

use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserGroup as UserGroupRepository;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Notifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use Illuminate\Support\Collection;

class UserGroupNotifier extends Notifier implements UserGroupRepository
{

    /**
     * @var UserGroupRepository
     */
    private $userGroupRepository;

    public function __construct(UserGroupRepository $userGroupRepository, ObserverStore $observerStore)
    {
        parent::__construct($observerStore, UserGroupRepository::class);
        $this->userGroupRepository = $userGroupRepository;
    }

    /**
     * Get all users who are members of a group
     *
     * @param Group $group
     * @return User[]|Collection Users who are members of the group
     */
    public function getUsersThroughGroup(Group $group): Collection
    {
        return $this->userGroupRepository->getUsersThroughGroup($group);
    }

    /**
     * Get all groups a user belongs to
     *
     * @param User $user
     * @return Group[]|Collection Groups the user is a member of
     */
    public function getGroupsThroughUser(User $user): Collection
    {
        return $this->userGroupRepository->getGroupsThroughUser($user);
    }

    /**
     * Add a user to a group
     *
     * @param User $user User to add to the group
     * @param Group $group Group to add the user to
     * @return void
     */
    public function addUserToGroup(User $user, Group $group): void
    {
        $this->userGroupRepository->addUserToGroup($user, $group);
        $this->notify('addUserToGroup', $user, $group);
    }

    /**
     * Remove a user from a group
     * @param User $user User to remove from the group
     * @param Group $group Group to remove the user from
     * @return void
     */
    public function removeUserFromGroup(User $user, Group $group): void
    {
        $this->userGroupRepository->removeUserFromGroup($user, $group);
        $this->notify('removeUserFromGroup', $user, $group);  
    }
}