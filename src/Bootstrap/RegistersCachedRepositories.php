<?php

namespace BristolSU\ControlDB\Bootstrap;

use BristolSU\ControlDB\Cache\Group as GroupCacher;
use BristolSU\ControlDB\Cache\Pivots\Tags\GroupGroupTag as GroupGroupTagCacher;
use BristolSU\ControlDB\Cache\Pivots\Tags\PositionPositionTag as PositionPositionTagCacher;
use BristolSU\ControlDB\Cache\Pivots\Tags\RoleRoleTag as RoleRoleTagCacher;
use BristolSU\ControlDB\Cache\Pivots\Tags\UserUserTag as UserUserTagCacher;
use BristolSU\ControlDB\Cache\Pivots\UserGroup as UserGroupCacher;
use BristolSU\ControlDB\Cache\Pivots\UserRole as UserRoleCacher;
use BristolSU\ControlDB\Cache\Position as PositionCacher;
use BristolSU\ControlDB\Cache\Role as RoleCacher;
use BristolSU\ControlDB\Cache\User as UserCacher;
use BristolSU\ControlDB\Cache\DataGroup as DataGroupCacher;
use BristolSU\ControlDB\Cache\DataPosition as DataPositionCacher;
use BristolSU\ControlDB\Cache\DataRole as DataRoleCacher;
use BristolSU\ControlDB\Cache\DataUser as DataUserCacher;
use BristolSU\ControlDB\Cache\Tags\GroupTag as GroupTagCacher;
use BristolSU\ControlDB\Cache\Tags\GroupTagCategory as GroupTagCategoryCacher;
use BristolSU\ControlDB\Cache\Tags\RoleTag as RoleTagCacher;
use BristolSU\ControlDB\Cache\Tags\RoleTagCategory as RoleTagCategoryCacher;
use BristolSU\ControlDB\Cache\Tags\PositionTag as PositionTagCacher;
use BristolSU\ControlDB\Cache\Tags\PositionTagCategory as PositionTagCategoryCacher;
use BristolSU\ControlDB\Cache\Tags\UserTag as UserTagCacher;
use BristolSU\ControlDB\Cache\Tags\UserTagCategory as UserTagCategoryCacher;
use BristolSU\ControlDB\Contracts\Repositories\DataGroup as DataGroupRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\DataPosition as DataPositionRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\DataRole as DataRoleRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\DataUser as DataUserRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\Group as GroupRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\GroupGroupTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\PositionPositionTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\RoleRoleTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\UserUserTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserGroup;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserRole;
use BristolSU\ControlDB\Contracts\Repositories\Position as PositionRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\Role as RoleRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTag;
use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTagCategory;
use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag;
use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTagCategory;
use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag;
use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTagCategory;
use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag;
use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTagCategory;
use BristolSU\ControlDB\Contracts\Repositories\User as UserRepositoryContract;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Container\Container;

trait RegistersCachedRepositories
{

    public function registerCachedRepositories(Container $app)
    {
        $this->registerBase($app);
        $this->registerData($app);
        $this->registerTags($app);
        $this->registerTagCategories($app);
        $this->registerPivots($app);
        

    }
    
    private function registerBase($app)
    {
        $app->extend(RoleRepositoryContract::class, function(RoleRepositoryContract $service, $app) {
            return new RoleCacher($service, $app->make(Repository::class));
        });
        $app->extend(UserRepositoryContract::class, function(UserRepositoryContract $service, $app) {
            return new UserCacher($service, $app->make(Repository::class));
        });
        $app->extend(GroupRepositoryContract::class, function(GroupRepositoryContract $service, $app) {
            return new GroupCacher($service, $app->make(Repository::class));
        });
        $app->extend(PositionRepositoryContract::class, function(PositionRepositoryContract $service, $app) {
            return new PositionCacher($service, $app->make(Repository::class));
        });
    }

    private function registerData($app)
    {
        $app->extend(DataRoleRepositoryContract::class, function(DataRoleRepositoryContract $service, $app) {
            return new DataRoleCacher($service, $app->make(Repository::class));
        });
        $app->extend(DataUserRepositoryContract::class, function(DataUserRepositoryContract $service, $app) {
            return new DataUserCacher($service, $app->make(Repository::class));
        });
        $app->extend(DataGroupRepositoryContract::class, function(DataGroupRepositoryContract $service, $app) {
            return new DataGroupCacher($service, $app->make(Repository::class));
        });
        $app->extend(DataPositionRepositoryContract::class, function(DataPositionRepositoryContract $service, $app) {
            return new DataPositionCacher($service, $app->make(Repository::class));
        });
    }
    
    private function registerTags($app)
    {
        $app->extend(GroupTag::class, function(GroupTag $service, $app) {
            return new GroupTagCacher($service, $app->make(Repository::class));
        });
        $app->extend(UserTag::class, function(UserTag $service, $app) {
            return new UserTagCacher($service, $app->make(Repository::class));
        });
        $app->extend(RoleTag::class, function(RoleTag $service, $app) {
            return new RoleTagCacher($service, $app->make(Repository::class));
        });
        $app->extend(PositionTag::class, function(PositionTag $service, $app) {
            return new PositionTagCacher($service, $app->make(Repository::class));
        });
    }

    private function registerTagCategories($app)
    {
        $app->extend(GroupTagCategory::class, function(GroupTagCategory $service, $app) {
            return new GroupTagCategoryCacher($service, $app->make(Repository::class));
        });
        $app->extend(UserTagCategory::class, function(UserTagCategory $service, $app) {
            return new UserTagCategoryCacher($service, $app->make(Repository::class));
        });
        $app->extend(RoleTagCategory::class, function(RoleTagCategory $service, $app) {
            return new RoleTagCategoryCacher($service, $app->make(Repository::class));
        });
        $app->extend(PositionTagCategory::class, function(PositionTagCategory $service, $app) {
            return new PositionTagCategoryCacher($service, $app->make(Repository::class));
        });
    }

    private function registerPivots($app)
    {
        $app->extend(GroupGroupTag::class, function(GroupGroupTag $service, $app) {
            return new GroupGroupTagCacher($service, $app->make(Repository::class));
        });
        $app->extend(RoleRoleTag::class, function(RoleRoleTag $service, $app) {
            return new RoleRoleTagCacher($service, $app->make(Repository::class));
        });
        $app->extend(UserUserTag::class, function(UserUserTag $service, $app) {
            return new UserUserTagCacher($service, $app->make(Repository::class));
        });
        $app->extend(PositionPositionTag::class, function(PositionPositionTag $service, $app) {
            return new PositionPositionTagCacher($service, $app->make(Repository::class));
        });
        $app->extend(UserGroup::class, function(UserGroup $service, $app) {
            return new UserGroupCacher($service, $app->make(Repository::class));
        });
        $app->extend(UserRole::class, function(UserRole $service, $app) {
            return new UserRoleCacher($service, $app->make(Repository::class));
        });
    }
}