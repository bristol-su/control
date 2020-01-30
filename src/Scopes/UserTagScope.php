<?php

namespace BristolSU\ControlDB\Scopes;

use BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory as UserTagCategoryModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTagCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Only retrieves tags with a tag category of type user.
 */
class UserTagScope implements Scope
{

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $userTagCategories = app(UserTagCategory::class)->all()->map(function(UserTagCategoryModel $userTagCategory) {
            return $userTagCategory->id();
        });
        
        $builder->whereIn('tag_category_id', $userTagCategories);
    }
}