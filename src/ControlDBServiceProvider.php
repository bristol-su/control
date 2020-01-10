<?php

namespace BristolSU\ControlDB;

use BristolSU\ControlDB\Commands\SeedDatabase;
use BristolSU\ControlDB\Contracts\Models\DataUser as DataUserContract;
use BristolSU\ControlDB\Contracts\Repositories\DataUser as DataUserRepositoryContract;
use BristolSU\ControlDB\Models\DataUser;
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
use BristolSU\ControlDB\Repositories\DataUser as DataUserRepository;
use BristolSU\ControlDB\Repositories\Group as GroupRepository;
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
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;


// Tag models (contracts)

// Tag models

// Tag repositories (contracts)

// Tag repositories

class ControlDBServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->bindContracts();
        $this->registerCommands();
        $this->registerMigrations();
    }

    public function boot()
    {
        Relation::morphMap([
            'user' => UserModel::class,
            'group' => GroupModel::class,
            'role' => RoleModel::class,
            'position' => PositionModel::class
        ]);

        $this->app->make(Factory::class)->load(__DIR__ . '/../database/factories');
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

        // Base Repositories
        $this->app->bind(GroupRepositoryContract::class, GroupRepository::class);
        $this->app->bind(RoleRepositoryContract::class, RoleRepository::class);
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(PositionRepositoryContract::class, PositionRepository::class);
        $this->app->bind(DataUserRepositoryContract::class, DataUserRepository::class);
        
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
    }

    public function registerCommands()
    {
        $this->commands([
            SeedDatabase::class
        ]);
    }


}