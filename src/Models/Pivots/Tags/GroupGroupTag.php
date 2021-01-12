<?php

namespace BristolSU\ControlDB\Models\Pivots\Tags;

use BristolSU\ControlDB\Scopes\GroupGroupTagScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Handles the relationship between a group and a group tag
 */
class GroupGroupTag extends Model
{
    use SoftDeletes;

    /**
     * Fillable attributes
     *
     * - Tag id: The ID of the group tag
     * - Taggable ID: The ID of the group
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
     * - Add scope to only retrieve group tags from the table
     * - Set the taggable_type to group on creation
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new GroupGroupTagScope());
        static::creating(function($model) {
            $model->taggable_type = 'group';
        });
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

}
