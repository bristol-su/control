<?php

namespace BristolSU\ControlDB\Models\Pivots\Tags;

use BristolSU\ControlDB\Scopes\RoleRoleTagScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Handles the relationship between a role and a role tag
 */
class RoleRoleTag extends Model
{
    use SoftDeletes;

    /**
     * Fillable attributes
     *
     * - Tag id: The ID of the role tag
     * - Taggable ID: The ID of the role
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
     * - Add scope to only retrieve role tags from the table
     * - Set the taggable_type to role on creation
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new RoleRoleTagScope());
        static::creating(function($model) {
            $model->taggable_type = 'role';
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
