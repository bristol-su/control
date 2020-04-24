<?php

namespace BristolSU\ControlDB\Bootstrap;

use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use BristolSU\ControlDB\Observers\NotifyObservers\GroupNotifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Pivots\Tags\GroupGroupTagNotifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Pivots\Tags\PositionPositionTagNotifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Pivots\Tags\RoleRoleTagNotifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Pivots\Tags\UserUserTagNotifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Pivots\UserGroupNotifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Pivots\UserRoleNotifier;
use BristolSU\ControlDB\Observers\NotifyObservers\PositionNotifier;
use BristolSU\ControlDB\Observers\NotifyObservers\RoleNotifier;
use BristolSU\ControlDB\Observers\NotifyObservers\UserNotifier;
use BristolSU\ControlDB\Observers\NotifyObservers\DataGroupNotifier;
use BristolSU\ControlDB\Observers\NotifyObservers\DataPositionNotifier;
use BristolSU\ControlDB\Observers\NotifyObservers\DataRoleNotifier;
use BristolSU\ControlDB\Observers\NotifyObservers\DataUserNotifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Tags\GroupTagNotifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Tags\GroupTagCategoryNotifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Tags\RoleTagNotifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Tags\RoleTagCategoryNotifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Tags\PositionTagNotifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Tags\PositionTagCategoryNotifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Tags\UserTagNotifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Tags\UserTagCategoryNotifier;
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
use Illuminate\Contracts\Container\Container;

trait RegistersObserverFramework
{

    public function registerObserversFramework(Container $app)
    {
        $this->registerBaseObserver($app);
        $this->registerDataObserver($app);
        $this->registerTagsObserver($app);
        $this->registerTagCategoriesObserver($app);
        $this->registerPivotsObserver($app);


    }

    private function registerBaseObserver($app)
    {
        $app->extend(RoleRepositoryContract::class, function(RoleRepositoryContract $service, $app) {
            return new RoleNotifier($service, $app->make(ObserverStore::class));
        });
        $app->extend(UserRepositoryContract::class, function(UserRepositoryContract $service, $app) {
            return new UserNotifier($service, $app->make(ObserverStore::class));
        });
        $app->extend(GroupRepositoryContract::class, function(GroupRepositoryContract $service, $app) {
            return new GroupNotifier($service, $app->make(ObserverStore::class));
        });
        $app->extend(PositionRepositoryContract::class, function(PositionRepositoryContract $service, $app) {
            return new PositionNotifier($service, $app->make(ObserverStore::class));
        });
    }

    private function registerDataObserver($app)
    {
        $app->extend(DataRoleRepositoryContract::class, function(DataRoleRepositoryContract $service, $app) {
            return new DataRoleNotifier($service, $app->make(ObserverStore::class));
        });
        $app->extend(DataUserRepositoryContract::class, function(DataUserRepositoryContract $service, $app) {
            return new DataUserNotifier($service, $app->make(ObserverStore::class));
        });
        $app->extend(DataGroupRepositoryContract::class, function(DataGroupRepositoryContract $service, $app) {
            return new DataGroupNotifier($service, $app->make(ObserverStore::class));
        });
        $app->extend(DataPositionRepositoryContract::class, function(DataPositionRepositoryContract $service, $app) {
            return new DataPositionNotifier($service, $app->make(ObserverStore::class));
        });
    }

    private function registerTagsObserver($app)
    {
        $app->extend(GroupTag::class, function(GroupTag $service, $app) {
            return new GroupTagNotifier($service, $app->make(ObserverStore::class));
        });
        $app->extend(UserTag::class, function(UserTag $service, $app) {
            return new UserTagNotifier($service, $app->make(ObserverStore::class));
        });
        $app->extend(RoleTag::class, function(RoleTag $service, $app) {
            return new RoleTagNotifier($service, $app->make(ObserverStore::class));
        });
        $app->extend(PositionTag::class, function(PositionTag $service, $app) {
            return new PositionTagNotifier($service, $app->make(ObserverStore::class));
        });
    }

    private function registerTagCategoriesObserver($app)
    {
        $app->extend(GroupTagCategory::class, function(GroupTagCategory $service, $app) {
            return new GroupTagCategoryNotifier($service, $app->make(ObserverStore::class));
        });
        $app->extend(UserTagCategory::class, function(UserTagCategory $service, $app) {
            return new UserTagCategoryNotifier($service, $app->make(ObserverStore::class));
        });
        $app->extend(RoleTagCategory::class, function(RoleTagCategory $service, $app) {
            return new RoleTagCategoryNotifier($service, $app->make(ObserverStore::class));
        });
        $app->extend(PositionTagCategory::class, function(PositionTagCategory $service, $app) {
            return new PositionTagCategoryNotifier($service, $app->make(ObserverStore::class));
        });
    }

    private function registerPivotsObserver($app)
    {
        $app->extend(GroupGroupTag::class, function(GroupGroupTag $service, $app) {
            return new GroupGroupTagNotifier($service, $app->make(ObserverStore::class));
        });
        $app->extend(RoleRoleTag::class, function(RoleRoleTag $service, $app) {
            return new RoleRoleTagNotifier($service, $app->make(ObserverStore::class));
        });
        $app->extend(UserUserTag::class, function(UserUserTag $service, $app) {
            return new UserUserTagNotifier($service, $app->make(ObserverStore::class));
        });
        $app->extend(PositionPositionTag::class, function(PositionPositionTag $service, $app) {
            return new PositionPositionTagNotifier($service, $app->make(ObserverStore::class));
        });
        $app->extend(UserGroup::class, function(UserGroup $service, $app) {
            return new UserGroupNotifier($service, $app->make(ObserverStore::class));
        });
        $app->extend(UserRole::class, function(UserRole $service, $app) {
            return new UserRoleNotifier($service, $app->make(ObserverStore::class));
        });
    }
}