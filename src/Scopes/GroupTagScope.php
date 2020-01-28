<?php

namespace BristolSU\ControlDB\Scopes;

use BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory as GroupTagCategoryAlias;
use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTagCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class GroupTagScope implements Scope
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
        $groupTagCategories = app(GroupTagCategory::class)->all()->map(function(GroupTagCategoryAlias $groupTagCategory) {
            return $groupTagCategory->id();
        });

        $builder->whereIn('tag_category_id', $groupTagCategories);
    }
}