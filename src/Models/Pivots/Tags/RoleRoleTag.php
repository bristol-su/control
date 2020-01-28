<?php

namespace BristolSU\ControlDB\Models\Pivots\Tags;

use BristolSU\ControlDB\Scopes\RoleRoleTagScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleRoleTag extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'tag_id', 'taggable_id'
    ];
    
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
    
    public $table = 'control_taggables';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new RoleRoleTagScope());
        static::creating(function($model) {
            $model->taggable_type = 'role';
        });
    }

}