<?php

namespace BristolSU\ControlDB;

use BristolSU\Support\Control\Contracts\Models\Group as GroupModelContract;
use BristolSU\Support\Control\Contracts\Models\Role as RoleModelContract;
use BristolSU\Support\Control\Contracts\Models\User as UserContract;
use BristolSU\Support\Control\Contracts\Models\Position as PositionContract;

use BristolSU\ControlDB\Models\Group as GroupModel;
use BristolSU\ControlDB\Models\Role as RoleModel;
use BristolSU\ControlDB\Models\User as UserModel;
use BristolSU\ControlDB\Models\Position as PositionModel;


use BristolSU\Support\Control\Contracts\Repositories\Group as GroupRepositoryContract;
use BristolSU\Support\Control\Contracts\Repositories\Role as RoleRepositoryContract;
use BristolSU\Support\Control\Contracts\Repositories\User as UserRepositoryContract;
use BristolSU\Support\Control\Contracts\Repositories\Position as PositionRepositoryContract;
use BristolSU\ControlDB\Repositories\Group as GroupRepository;
use BristolSU\ControlDB\Repositories\Role as RoleRepository;
use BristolSU\ControlDB\Repositories\User as UserRepository;
use BristolSU\ControlDB\Repositories\Position as PositionRepository;

// Tag models (contracts)
use BristolSU\Support\Control\Contracts\Models\Tags\GroupTagCategory as GroupTagCategoryModelContract;
use BristolSU\Support\Control\Contracts\Models\Tags\UserTagCategory as UserTagCategoryModelContract;
use BristolSU\Support\Control\Contracts\Models\Tags\RoleTagCategory as RoleTagCategoryModelContract;
use BristolSU\Support\Control\Contracts\Models\Tags\PositionTagCategory as PositionTagCategoryModelContract;
use BristolSU\Support\Control\Contracts\Models\Tags\GroupTag as GroupTagModelContract;
use BristolSU\Support\Control\Contracts\Models\Tags\UserTag as UserTagModelContract;
use BristolSU\Support\Control\Contracts\Models\Tags\RoleTag as RoleTagModelContract;
use BristolSU\Support\Control\Contracts\Models\Tags\PositionTag as PositionTagModelContract;

// Tag models
use BristolSU\ControlDB\Models\Tags\GroupTag as GroupTagModel;
use BristolSU\ControlDB\Models\Tags\GroupTagCategory as GroupTagCategoryModel;
use BristolSU\ControlDB\Models\Tags\UserTag as UserTagModel;
use BristolSU\ControlDB\Models\Tags\UserTagCategory as UserTagCategoryModel;
use BristolSU\ControlDB\Models\Tags\RoleTag as RoleTagModel;
use BristolSU\ControlDB\Models\Tags\RoleTagCategory as RoleTagCategoryModel;
use BristolSU\ControlDB\Models\Tags\PositionTag as PositionTagModel;
use BristolSU\ControlDB\Models\Tags\PositionTagCategory as PositionTagCategoryModel;

// Tag repositories (contracts)
use BristolSU\Support\Control\Contracts\Repositories\Tags\GroupTagCategory as GroupTagCategoryRepositoryContract;
use BristolSU\Support\Control\Contracts\Repositories\Tags\UserTagCategory as UserTagCategoryRepositoryContract;
use BristolSU\Support\Control\Contracts\Repositories\Tags\RoleTagCategory as RoleTagCategoryRepositoryContract;
use BristolSU\Support\Control\Contracts\Repositories\Tags\PositionTagCategory as PositionTagCategoryRepositoryContract;
use BristolSU\Support\Control\Contracts\Repositories\Tags\GroupTag as GroupTagRepositoryContract;
use BristolSU\Support\Control\Contracts\Repositories\Tags\UserTag as UserTagRepositoryContract;
use BristolSU\Support\Control\Contracts\Repositories\Tags\RoleTag as RoleTagRepositoryContract;
use BristolSU\Support\Control\Contracts\Repositories\Tags\PositionTag as PositionTagRepositoryContract;

// Tag repositories
use BristolSU\ControlDB\Repositories\Tags\GroupTag as GroupTagRepository;
use BristolSU\ControlDB\Repositories\Tags\GroupTagCategory as GroupTagCategoryRepository;
use BristolSU\ControlDB\Repositories\Tags\UserTag as UserTagRepository;
use BristolSU\ControlDB\Repositories\Tags\UserTagCategory as UserTagCategoryRepository;
use BristolSU\ControlDB\Repositories\Tags\RoleTag as RoleTagRepository;
use BristolSU\ControlDB\Repositories\Tags\RoleTagCategory as RoleTagCategoryRepository;
use BristolSU\ControlDB\Repositories\Tags\PositionTag as PositionTagRepository;
use BristolSU\ControlDB\Repositories\Tags\PositionTagCategory as PositionTagCategoryRepository;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class ControlDBServiceProvider extends ServiceProvider
{

    public function register()
    {
        // Base Models
        $this->app->bind(GroupModelContract::class, GroupModel::class);
        $this->app->bind(RoleModelContract::class, RoleModel::class);
        $this->app->bind(UserContract::class, UserModel::class);
        $this->app->bind(PositionContract::class, PositionModel::class);

        // Base Repositories
        $this->app->bind(GroupRepositoryContract::class, GroupRepository::class);
        $this->app->bind(RoleRepositoryContract::class, RoleRepository::class);
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(PositionRepositoryContract::class, PositionRepository::class);

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

    public function boot()
    {
        Relation::morphMap([
            'user' => \BristolSU\Support\User\User::class,
            'group' => \BristolSU\ControlDB\Models\Group::class,
            'role' => \BristolSU\ControlDB\Models\Role::class,
            'position' => \BristolSU\ControlDB\Models\Position::class
        ]);
    }
}