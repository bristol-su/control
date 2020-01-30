<?php

namespace BristolSU\ControlDB\Scopes;

use BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory as PositionTagCategoryAlias;
use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTagCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Only retrieves tags with a tag category of type position.
 */
class PositionTagScope implements Scope
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
        $positionTagCategories = app(PositionTagCategory::class)->all()->map(function(PositionTagCategoryAlias $positionTagCategory) {
            return $positionTagCategory->id();
        });

        $builder->whereIn('tag_category_id', $positionTagCategories);
    }
}