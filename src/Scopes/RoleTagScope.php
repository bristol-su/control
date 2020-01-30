<?php

namespace BristolSU\ControlDB\Scopes;

use BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory as RoleTagCategoryAlias;
use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTagCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Only retrieves tags with a tag category of type role.
 */
class RoleTagScope implements Scope
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
        $roleTagCategories = app(RoleTagCategory::class)->all()->map(function(RoleTagCategoryAlias $roleTagCategory) {
            return $roleTagCategory->id();
        });

        $builder->whereIn('tag_category_id', $roleTagCategories);
    }
}