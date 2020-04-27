<?php

namespace BristolSU\ControlDB\Cache\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\RoleRoleTag as RoleRoleTagRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class RoleRoleTag implements RoleRoleTagRepository
{
    /**
     * @var RoleRoleTagRepository
     */
    private $roleRoleTagRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(RoleRoleTagRepository $roleRoleTagRepository, Repository $cache)
    {
        $this->roleRoleTagRepository = $roleRoleTagRepository;
        $this->cache = $cache;
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
    }

    /**
     * Get all tags a role is tagged with
     *
     * @param Role $role Role to retrieve tags from
     * @return Collection|RoleTag[] Tags the role is tagged with
     */
    public function getTagsThroughRole(Role $role): Collection
    {
        return $this->cache->rememberForever(static::class . '@getTagsThroughRole:' . $role->id(), function() use ($role) {
            return $this->roleRoleTagRepository->getTagsThroughRole($role);
        });
    }

    /**
     * Get all roles tagged with a tag
     *
     * @param RoleTag $roleTag Tag to use to retrieve roles
     * @return Collection|Role[] Roles tagged with the given tag
     */
    public function getRolesThroughTag(RoleTag $roleTag): Collection
    {
        return $this->cache->rememberForever(static::class . '@getRolesThroughTag:' . $roleTag->id(), function() use ($roleTag) {
            return $this->roleRoleTagRepository->getRolesThroughTag($roleTag);
        });   
    }
}