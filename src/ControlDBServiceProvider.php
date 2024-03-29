<?php

namespace BristolSU\ControlDB;

use BristolSU\ControlDB\Events\Pivots\UserGroup\UserGroupEventDispatcher;
use BristolSU\ControlDB\Events\Pivots\UserRole\UserRoleEventDispatcher;
use BristolSU\ControlDB\AdditionalProperties\AdditionalPropertySingletonStore;
use BristolSU\ControlDB\AdditionalProperties\AdditionalPropertyStore;
use BristolSU\ControlDB\Bootstrap\RegistersCachedRepositories;
use BristolSU\ControlDB\Bootstrap\RegistersObserverFramework;
use BristolSU\ControlDB\Commands\SeedDatabase;
use BristolSU\ControlDB\Contracts\Repositories\DataUser as DataUserRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\DataGroup as DataGroupRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\DataRole as DataRoleRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\DataPosition as DataPositionRepositoryContract;
use BristolSU\ControlDB\Contracts\Models\DataUser as DataUserContract;
use BristolSU\ControlDB\Contracts\Models\DataGroup as DataGroupContract;
use BristolSU\ControlDB\Contracts\Models\DataRole as DataRoleContract;
use BristolSU\ControlDB\Contracts\Models\DataPosition as DataPositionContract;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\GroupGroupTag as GroupGroupTagContract;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\UserUserTag as UserUserTagContract;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\RoleRoleTag as RoleRoleTagContract;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\PositionPositionTag as PositionPositionTagContract;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserGroup as UserGroupContract;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserRole as UserRoleContract;
use BristolSU\ControlDB\Events\DataGroup\DataGroupEventDispatcher;
use BristolSU\ControlDB\Events\DataPosition\DataPositionEventDispatcher;
use BristolSU\ControlDB\Events\DataRole\DataRoleEventDispatcher;
use BristolSU\ControlDB\Events\DataUser\DataUserEventDispatcher;
use BristolSU\ControlDB\Events\Pivots\Tags\GroupGroupTag\GroupGroupTagEventDispatcher;
use BristolSU\ControlDB\Events\Pivots\Tags\PositionPositionTag\PositionPositionTagEventDispatcher;
use BristolSU\ControlDB\Events\Pivots\Tags\RoleRoleTag\RoleRoleTagEventDispatcher;
use BristolSU\ControlDB\Events\Pivots\Tags\UserUserTag\UserUserTagEventDispatcher;
use BristolSU\ControlDB\Events\User\UserEventDispatcher;
use BristolSU\ControlDB\Events\Group\GroupEventDispatcher;
use BristolSU\ControlDB\Events\Role\RoleEventDispatcher;
use BristolSU\ControlDB\Events\Position\PositionEventDispatcher;
use BristolSU\ControlDB\Export\ExportControlCommand;
use BristolSU\ControlDB\Export\ExportManager;
use BristolSU\ControlDB\Models\DataUser;
use BristolSU\ControlDB\Models\DataGroup;
use BristolSU\ControlDB\Models\DataRole;
use BristolSU\ControlDB\Models\DataPosition;
use BristolSU\ControlDB\Models\Group as GroupModel;
use BristolSU\ControlDB\Models\Position as PositionModel;
use BristolSU\ControlDB\Models\Role as RoleModel;
use BristolSU\ControlDB\Models\Tags\GroupTag as GroupTagModel;
use BristolSU\ControlDB\Models\Tags\GroupTagCategory as GroupTagCategoryModel;
use BristolSU\ControlDB\Models\Tags\PositionTag as PositionTagModel;
use BristolSU\ControlDB\Models\Tags\PositionTagCategory as PositionTagCategoryModel;
use BristolSU\ControlDB\Models\Tags\RoleTag as RoleTagModel;
use BristolSU\ControlDB\Models\Tags\RoleTagCategory as RoleTagCategoryModel;
use BristolSU\ControlDB\Models\Tags\UserTag as UserTagModel;
use BristolSU\ControlDB\Models\Tags\UserTagCategory as UserTagCategoryModel;
use BristolSU\ControlDB\Models\User as UserModel;
use BristolSU\ControlDB\Observers\DataGroupObserverClearCache;
use BristolSU\ControlDB\Observers\DataPositionObserverClearCache;
use BristolSU\ControlDB\Observers\DataRoleObserverClearCache;
use BristolSU\ControlDB\Observers\DataUserObserverClearCache;
use BristolSU\ControlDB\Observers\GroupObserverCascadeDelete;
use BristolSU\ControlDB\Observers\GroupObserverClearCache;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Observe;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use BristolSU\ControlDB\Observers\Pivots\Tags\GroupGroupTagObserverClearCache;
use BristolSU\ControlDB\Observers\Pivots\Tags\PositionPositionTagObserverClearCache;
use BristolSU\ControlDB\Observers\Pivots\Tags\RoleRoleTagObserverClearCache;
use BristolSU\ControlDB\Observers\Pivots\Tags\UserUserTagObserverClearCache;
use BristolSU\ControlDB\Observers\Pivots\UserGroupObserverClearCache;
use BristolSU\ControlDB\Observers\Pivots\UserRoleObserverClearCache;
use BristolSU\ControlDB\Observers\PositionObserverCascadeDelete;
use BristolSU\ControlDB\Observers\PositionObserverClearCache;
use BristolSU\ControlDB\Observers\RoleObserverCascadeDelete;
use BristolSU\ControlDB\Observers\RoleObserverClearCache;
use BristolSU\ControlDB\Observers\Tags\GroupTagCategoryObserverCascadeDelete;
use BristolSU\ControlDB\Observers\Tags\GroupTagCategoryObserverClearCache;
use BristolSU\ControlDB\Observers\Tags\GroupTagObserverCascadeDelete;
use BristolSU\ControlDB\Observers\Tags\GroupTagObserverClearCache;
use BristolSU\ControlDB\Observers\Tags\PositionTagCategoryObserverCascadeDelete;
use BristolSU\ControlDB\Observers\Tags\PositionTagCategoryObserverClearCache;
use BristolSU\ControlDB\Observers\Tags\PositionTagObserverCascadeDelete;
use BristolSU\ControlDB\Observers\Tags\PositionTagObserverClearCache;
use BristolSU\ControlDB\Observers\Tags\RoleTagCategoryObserverCascadeDelete;
use BristolSU\ControlDB\Observers\Tags\RoleTagCategoryObserverClearCache;
use BristolSU\ControlDB\Observers\Tags\RoleTagObserverCascadeDelete;
use BristolSU\ControlDB\Observers\Tags\RoleTagObserverClearCache;
use BristolSU\ControlDB\Observers\Tags\UserTagCategoryObserverCascadeDelete;
use BristolSU\ControlDB\Observers\Tags\UserTagCategoryObserverClearCache;
use BristolSU\ControlDB\Observers\Tags\UserTagObserverCascadeDelete;
use BristolSU\ControlDB\Observers\Tags\UserTagObserverClearCache;
use BristolSU\ControlDB\Observers\UserObserverCascadeDelete;
use BristolSU\ControlDB\Observers\UserObserverClearCache;
use BristolSU\ControlDB\Repositories\DataUser as DataUserRepository;
use BristolSU\ControlDB\Repositories\DataGroup as DataGroupRepository;
use BristolSU\ControlDB\Repositories\DataRole as DataRoleRepository;
use BristolSU\ControlDB\Repositories\DataPosition as DataPositionRepository;
use BristolSU\ControlDB\Repositories\Group as GroupRepository;
use BristolSU\ControlDB\Repositories\Pivots\Tags\GroupGroupTag;
use BristolSU\ControlDB\Repositories\Pivots\Tags\PositionPositionTag;
use BristolSU\ControlDB\Repositories\Pivots\Tags\RoleRoleTag;
use BristolSU\ControlDB\Repositories\Pivots\Tags\UserUserTag;
use BristolSU\ControlDB\Repositories\Pivots\UserGroup;
use BristolSU\ControlDB\Repositories\Pivots\UserRole;
use BristolSU\ControlDB\Repositories\Position as PositionRepository;
use BristolSU\ControlDB\Repositories\Role as RoleRepository;
use BristolSU\ControlDB\Repositories\Tags\GroupTag as GroupTagRepository;
use BristolSU\ControlDB\Repositories\Tags\GroupTagCategory as GroupTagCategoryRepository;
use BristolSU\ControlDB\Repositories\Tags\PositionTag as PositionTagRepository;
use BristolSU\ControlDB\Repositories\Tags\PositionTagCategory as PositionTagCategoryRepository;
use BristolSU\ControlDB\Repositories\Tags\RoleTag as RoleTagRepository;
use BristolSU\ControlDB\Repositories\Tags\RoleTagCategory as RoleTagCategoryRepository;
use BristolSU\ControlDB\Repositories\Tags\UserTag as UserTagRepository;
use BristolSU\ControlDB\Repositories\Tags\UserTagCategory as UserTagCategoryRepository;
use BristolSU\ControlDB\Repositories\User as UserRepository;
use BristolSU\ControlDB\Contracts\Models\Group as GroupModelContract;
use BristolSU\ControlDB\Contracts\Models\Position as PositionContract;
use BristolSU\ControlDB\Contracts\Models\Role as RoleModelContract;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag as GroupTagModelContract;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory as GroupTagCategoryModelContract;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag as PositionTagModelContract;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory as PositionTagCategoryModelContract;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag as RoleTagModelContract;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory as RoleTagCategoryModelContract;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTag as UserTagModelContract;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory as UserTagCategoryModelContract;
use BristolSU\ControlDB\Contracts\Models\User as UserContract;
use BristolSU\ControlDB\Contracts\Repositories\Group as GroupRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\Position as PositionRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\Role as RoleRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTag as GroupTagRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTagCategory as GroupTagCategoryRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag as PositionTagRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTagCategory as PositionTagCategoryRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag as RoleTagRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTagCategory as RoleTagCategoryRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag as UserTagRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTagCategory as UserTagCategoryRepositoryContract;
use BristolSU\ControlDB\Contracts\Repositories\User as UserRepositoryContract;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ControlDBServiceProvider extends ServiceProvider
{
    use RegistersCachedRepositories, RegistersObserverFramework;

    public function register()
    {
        $this->bindContracts();
        $this->registerObserversFramework($this->app);
        $this->registerCachedRepositories($this->app);
        $this->registerModelEvents();
        $this->registerCommands();
        $this->registerMigrations();
        $this->registerConfig();
        $this->app->singleton('control-exporter', function() {
            return new ExportManager($this->app);
        });
    }

    public function boot()
    {
        $this->setupRouteModelBinding();
        $this->setupRoutes();
        $this->setupObservers();
    }

    public function registerModelEvents()
    {
        $this->app->extend(DataUserRepositoryContract::class, fn (DataUserRepositoryContract $service) => new DataUserEventDispatcher($service));
        $this->app->extend(UserRepositoryContract::class, fn (UserRepositoryContract $service) => new UserEventDispatcher($service));
        $this->app->extend(DataGroupRepositoryContract::class, fn (DataGroupRepositoryContract $service) => new DataGroupEventDispatcher($service));
        $this->app->extend(GroupRepositoryContract::class, fn (GroupRepositoryContract $service) => new GroupEventDispatcher($service));
        $this->app->extend(DataRoleRepositoryContract::class, fn (DataRoleRepositoryContract $service) => new DataRoleEventDispatcher($service));
        $this->app->extend(RoleRepositoryContract::class, fn (RoleRepositoryContract $service) => new RoleEventDispatcher($service));
        $this->app->extend(DataPositionRepositoryContract::class, fn (DataPositionRepositoryContract $service) => new DataPositionEventDispatcher($service));
        $this->app->extend(PositionRepositoryContract::class, fn (PositionRepositoryContract $service) => new PositionEventDispatcher($service));
        $this->app->extend(UserGroupContract::class, fn (UserGroupContract $service) => new UserGroupEventDispatcher($service));
        $this->app->extend(UserRoleContract::class, fn (UserRoleContract $service) => new UserRoleEventDispatcher($service));
        $this->app->extend(UserUserTagContract::class, fn (UserUserTagContract $service) => new UserUserTagEventDispatcher($service));
        $this->app->extend(GroupGroupTagContract::class, fn (GroupGroupTagContract $service) => new GroupGroupTagEventDispatcher($service));
        $this->app->extend(RoleRoleTagContract::class, fn (RoleRoleTagContract $service) => new RoleRoleTagEventDispatcher($service));
        $this->app->extend(PositionPositionTagContract::class, fn (PositionPositionTagContract $service) => new PositionPositionTagEventDispatcher($service));
    }

    /**
     * Register config
     */
    protected function registerConfig()
    {
        $this->publishes([__DIR__ .'/../config/control.php' => config_path('control.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ .'/../config/control.php', 'control'
        );
    }

    public function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function bindContracts()
    {
        // Base Models
        $this->app->bind(GroupModelContract::class, GroupModel::class);
        $this->app->bind(RoleModelContract::class, RoleModel::class);
        $this->app->bind(UserContract::class, UserModel::class);
        $this->app->bind(PositionContract::class, PositionModel::class);
        $this->app->bind(DataUserContract::class, DataUser::class);
        $this->app->bind(DataGroupContract::class, DataGroup::class);
        $this->app->bind(DataRoleContract::class, DataRole::class);
        $this->app->bind(DataPositionContract::class, DataPosition::class);

        // Base Repositories
        $this->app->bind(GroupRepositoryContract::class, GroupRepository::class);
        $this->app->bind(RoleRepositoryContract::class, RoleRepository::class);
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(PositionRepositoryContract::class, PositionRepository::class);
        $this->app->bind(DataUserRepositoryContract::class, DataUserRepository::class);
        $this->app->bind(DataGroupRepositoryContract::class, DataGroupRepository::class);
        $this->app->bind(DataRoleRepositoryContract::class, DataRoleRepository::class);
        $this->app->bind(DataPositionRepositoryContract::class, DataPositionRepository::class);

        // Tag Models
        $this->app->bind(GroupTagModelContract::class, GroupTagModel::class);
        $this->app->bind(GroupTagCategoryModelContract::class, GroupTagCategoryModel::class);
        $this->app->bind(UserTagModelContract::class, UserTagModel::class);
        $this->app->bind(UserTagCategoryModelContract::class, UserTagCategoryModel::class);
        $this->app->bind(RoleTagModelContract::class, RoleTagModel::class);
        $this->app->bind(RoleTagCategoryModelContract::class, RoleTagCategoryModel::class);
        $this->app->bind(PositionTagModelContract::class, PositionTagModel::class);
        $this->app->bind(PositionTagCategoryModelContract::class, PositionTagCategoryModel::class);

        // Tag Repositories
        $this->app->bind(GroupTagRepositoryContract::class, GroupTagRepository::class);
        $this->app->bind(GroupTagCategoryRepositoryContract::class, GroupTagCategoryRepository::class);
        $this->app->bind(UserTagRepositoryContract::class, UserTagRepository::class);
        $this->app->bind(UserTagCategoryRepositoryContract::class, UserTagCategoryRepository::class);
        $this->app->bind(RoleTagRepositoryContract::class, RoleTagRepository::class);
        $this->app->bind(RoleTagCategoryRepositoryContract::class, RoleTagCategoryRepository::class);
        $this->app->bind(PositionTagRepositoryContract::class, PositionTagRepository::class);
        $this->app->bind(PositionTagCategoryRepositoryContract::class, PositionTagCategoryRepository::class);

        // Additional Properties
        $this->app->singleton(AdditionalPropertyStore::class, AdditionalPropertySingletonStore::class);

        // Pivot Repositories
        $this->app->bind(UserGroupContract::class, UserGroup::class);
        $this->app->bind(UserRoleContract::class, UserRole::class);
        $this->app->bind(GroupGroupTagContract::class, GroupGroupTag::class);
        $this->app->bind(UserUserTagContract::class, UserUserTag::class);
        $this->app->bind(RoleRoleTagContract::class, RoleRoleTag::class);
        $this->app->bind(PositionPositionTagContract::class, PositionPositionTag::class);

        $this->app->singleton(ObserverStore::class);

    }

    public function registerCommands()
    {
        $this->commands([
            SeedDatabase::class,
            ExportControlCommand::class,
        ]);
    }

    public function setupRouteModelBinding()
    {
        Route::model('control_group', GroupModel::class);
        Route::model('control_role', RoleModel::class);
        Route::model('control_user', UserModel::class);
        Route::model('control_position', PositionModel::class);
        Route::model('control_group_tag', GroupTagModel::class);
        Route::model('control_role_tag', RoleTagModel::class);
        Route::model('control_user_tag', UserTagModel::class);
        Route::model('control_position_tag', PositionTagModel::class);
        Route::model('control_group_tag_category', GroupTagCategoryModel::class);
        Route::model('control_role_tag_category', RoleTagCategoryModel::class);
        Route::model('control_user_tag_category', UserTagCategoryModel::class);
        Route::model('control_position_tag_category', PositionTagCategoryModel::class);

        Route::bind('control_group', function($id) {
            return app(GroupRepositoryContract::class)->getById($id);
        });
        Route::bind('control_role', function($id) {
            return app(RoleRepositoryContract::class)->getById($id);
        });
        Route::bind('control_user', function($id) {
            return app(UserRepositoryContract::class)->getById($id);
        });
        Route::bind('control_position', function($id) {
            return app(PositionRepositoryContract::class)->getById($id);
        });

        Route::bind('control_group_tag', function($id) {
            return app(GroupTagRepositoryContract::class)->getById($id);
        });
        Route::bind('control_role_tag', function($id) {
            return app(RoleTagRepositoryContract::class)->getById($id);
        });
        Route::bind('control_user_tag', function($id) {
            return app(UserTagRepositoryContract::class)->getById($id);
        });
        Route::bind('control_position_tag', function($id) {
            return app(PositionTagRepositoryContract::class)->getById($id);
        });

        Route::bind('control_group_tag_category', function($id) {
            return app(GroupTagCategoryRepositoryContract::class)->getById($id);
        });
        Route::bind('control_role_tag_category', function($id) {
            return app(RoleTagCategoryRepositoryContract::class)->getById($id);
        });
        Route::bind('control_user_tag_category', function($id) {
            return app(UserTagCategoryRepositoryContract::class)->getById($id);
        });
        Route::bind('control_position_tag_category', function($id) {
            return app(PositionTagCategoryRepositoryContract::class)->getById($id);
        });
    }

    public function setupRoutes()
    {
        Route::prefix(config('control.api_prefix'))
            ->middleware(config('control.api_middleware'))
            ->namespace('BristolSU\ControlDB\Http\Controllers')
            ->group(__DIR__ . '/../routes/api.php');
    }

    private function setupObservers()
    {
        Observe::attach(RoleRepositoryContract::class, RoleObserverClearCache::class);
        Observe::attach(UserRepositoryContract::class, UserObserverClearCache::class);
        Observe::attach(GroupRepositoryContract::class, GroupObserverClearCache::class);
        Observe::attach(PositionRepositoryContract::class, PositionObserverClearCache::class);

        Observe::attach(DataUserRepositoryContract::class, DataUserObserverClearCache::class);
        Observe::attach(DataGroupRepositoryContract::class, DataGroupObserverClearCache::class);
        Observe::attach(DataRoleRepositoryContract::class, DataRoleObserverClearCache::class);
        Observe::attach(DataPositionRepositoryContract::class, DataPositionObserverClearCache::class);

        Observe::attach(GroupTagRepositoryContract::class, GroupTagObserverClearCache::class);
        Observe::attach(RoleTagRepositoryContract::class, RoleTagObserverClearCache::class);
        Observe::attach(UserTagRepositoryContract::class, UserTagObserverClearCache::class);
        Observe::attach(PositionTagRepositoryContract::class, PositionTagObserverClearCache::class);

        Observe::attach(GroupTagCategoryRepositoryContract::class, GroupTagCategoryObserverClearCache::class);
        Observe::attach(RoleTagCategoryRepositoryContract::class, RoleTagCategoryObserverClearCache::class);
        Observe::attach(UserTagCategoryRepositoryContract::class, UserTagCategoryObserverClearCache::class);
        Observe::attach(PositionTagCategoryRepositoryContract::class, PositionTagCategoryObserverClearCache::class);

        Observe::attach(UserGroupContract::class, UserGroupObserverClearCache::class);
        Observe::attach(UserRoleContract::class, UserRoleObserverClearCache::class);

        Observe::attach(GroupGroupTagContract::class, GroupGroupTagObserverClearCache::class);
        Observe::attach(UserUserTagContract::class, UserUserTagObserverClearCache::class);
        Observe::attach(RoleRoleTagContract::class, RoleRoleTagObserverClearCache::class);
        Observe::attach(PositionPositionTagContract::class, PositionPositionTagObserverClearCache::class);

        Observe::attach(GroupTagRepositoryContract::class, GroupTagObserverCascadeDelete::class);
        Observe::attach(UserTagRepositoryContract::class, UserTagObserverCascadeDelete::class);
        Observe::attach(RoleTagRepositoryContract::class, RoleTagObserverCascadeDelete::class);
        Observe::attach(PositionTagRepositoryContract::class, PositionTagObserverCascadeDelete::class);

        Observe::attach(GroupTagCategoryRepositoryContract::class, GroupTagCategoryObserverCascadeDelete::class);
        Observe::attach(UserTagCategoryRepositoryContract::class, UserTagCategoryObserverCascadeDelete::class);
        Observe::attach(RoleTagCategoryRepositoryContract::class, RoleTagCategoryObserverCascadeDelete::class);
        Observe::attach(PositionTagCategoryRepositoryContract::class, PositionTagCategoryObserverCascadeDelete::class);

        Observe::attach(RoleRepositoryContract::class, RoleObserverCascadeDelete::class);
        Observe::attach(UserRepositoryContract::class, UserObserverCascadeDelete::class);
        Observe::attach(GroupRepositoryContract::class, GroupObserverCascadeDelete::class);
        Observe::attach(PositionRepositoryContract::class, PositionObserverCascadeDelete::class);
    }


}
