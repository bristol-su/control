<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\RoleRoleTag as RoleRoleTagRepository;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Notifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use Illuminate\Support\Collection;

class RoleRoleTagNotifier extends Notifier implements RoleRoleTagRepository
{

    /**
     * @var RoleRoleTagRepository
     */
    private $roleRoleTagRepository;

    public function __construct(RoleRoleTagRepository $roleRoleTagRepository, ObserverStore $observerStore)
    {
        parent::__construct($observerStore, RoleRoleTagRepository::class);
        $this->roleRoleTagRepository = $roleRoleTagRepository;
    }

    /**
     * Tag a role
     *
     * @param RoleTag $roleTag Tag to tag the role with
     * @param Role $role Role to tag
     * @return void
     */
    public function addTagToRole(RoleTag $roleTag, Role $role): void
    {
        $this->roleRoleTagRepository->addTagToRole($roleTag, $role);
        $this->notify('addTagToRole', $roleTag, $role);
    }

    /**
     * Remove a tag from a role
     *
     * @param RoleTag $roleTag Tag to remove from the role
     * @param Role $role Role to remove the tag from
     * @return void
     */
    public function removeTagFromRole(RoleTag $roleTag, Role $role): void
    {
        $this->roleRoleTagRepository->removeTagFromRole($roleTag, $role);
        $this->notify('removeTagFromRole', $roleTag, $role);    
    }

    /**
     * Get all tags a role is tagged with
     *
     * @param Role $role Role to retrieve tags from
     * @return Collection|RoleTag[] Tags the role is tagged with
     */
    public function getTagsThroughRole(Role $role): Collection
    {
        return $this->roleRoleTagRepository->getTagsThroughRole($role);
    }

    /**
     * Get all roles tagged with a tag
     *
     * @param RoleTag $roleTag Tag to use to retrieve roles
     * @return Collection|Role[] Roles tagged with the given tag
     */
    public function getRolesThroughTag(RoleTag $roleTag): Collection
    {
        return $this->roleRoleTagRepository->getRolesThroughTag($roleTag);
    }
}