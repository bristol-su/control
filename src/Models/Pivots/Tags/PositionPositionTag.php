<?php

namespace BristolSU\ControlDB\Models\Pivots\Tags;

use BristolSU\ControlDB\Scopes\PositionPositionTagScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Handles the relationship between a position and a position tag
 */
class PositionPositionTag extends Model
{
    use SoftDeletes;

    /**
     * Fillable attributes
     *
     * - Tag id: The ID of the position tag
     * - Taggable ID: The ID of the position
     * @var array
     */
    protected $fillable = [
        'tag_id', 'taggable_id'
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Define the table to use
     *
     * @var string
     */
    public $table = 'control_taggables';

    /**
     * Boot the model
     *
     * - Add scope to only retrieve position tags from the table
     * - Set the taggable_type to position on creation
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new PositionPositionTagScope());
        static::creating(function($model) {
            $model->taggable_type = 'position';
        });
    }

}