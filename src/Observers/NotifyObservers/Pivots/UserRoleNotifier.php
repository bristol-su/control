<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers\Pivots;

use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserRole as UserRoleRepository;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Notifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use Illuminate\Support\Collection;

class UserRoleNotifier extends Notifier implements UserRoleRepository
{

    /**
     * @var UserRoleRepository
     */
    private $userRoleRepository;

    public function __construct(UserRoleRepository $userRoleRepository, ObserverStore $observerStore)
    {
        parent::__construct($observerStore, UserRoleRepository::class);
        $this->userRoleRepository = $userRoleRepository;
    }

    /**
     * Get all users who are members of a role
     *
     * @param Role $role
     * @return User[]|Collection Users who are members of the role
     */
    public function getUsersThroughRole(Role $role): Collection
    {
        return $this->userRoleRepository->getUsersThroughRole($role);
    }

    /**
     * Get all roles a user belongs to
     *
     * @param User $user
     * @return Role[]|Collection Roles the user is a member of
     */
    public function getRolesThroughUser(User $user): Collection
    {
        return $this->userRoleRepository->getRolesThroughUser($user);
    }

    /**
     * Add a user to a role
     *
     * @param User $user User to add to the role
     * @param Role $role Role to add the user to
     * @return void
     */
    public function addUserToRole(User $user, Role $role): void
    {
        $this->userRoleRepository->addUserToRole($user, $role);
        $this->notify('addUserToRole', $user, $role);
    }

    /**
     * Remove a user from a role
     * @param User $user User to remove from the role
     * @param Role $role Role to remove the user from
     * @return void
     */
    public function removeUserFromRole(User $user, Role $role): void
    {
        $this->userRoleRepository->removeUserFromRole($user, $role);
        $this->notify('removeUserFromRole', $user, $role);  
    }
}