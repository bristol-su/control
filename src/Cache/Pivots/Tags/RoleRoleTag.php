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
        $key = static::class . '@getTagsThroughRole:' . $role->id();
        if(!$this->cache->has($key)) {
            $roleTags = $this->roleRoleTagRepository->getTagsThroughRole($role);
            $this->cache->forever($key, $roleTags->map(fn(RoleTag $roleTag) => $roleTag->id())->all());
            return $roleTags;
        }
        return collect($this->cache->get($key))
            ->map(fn(int $roleTagId) => app(\BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag::class)->getById($roleTagId));
    }

    /**
     * Get all roles tagged with a tag
     *
     * @param RoleTag $roleTag Tag to use to retrieve roles
     * @return Collection|Role[] Roles tagged with the given tag
     */
    public function getRolesThroughTag(RoleTag $roleTag): Collection
    {
        $key = static::class . '@getRolesThroughTag:' . $roleTag->id();
        if(!$this->cache->has($key)) {
            $roles = $this->roleRoleTagRepository->getRolesThroughTag($roleTag);
            $this->cache->forever($key, $roles->map(fn(Role $role) => $role->id())->all());
            return $roles;
        }
        return collect($this->cache->get($key))
            ->map(fn(int $roleId) => app(\BristolSU\ControlDB\Contracts\Repositories\Role::class)->getById($roleId));
    }
}
