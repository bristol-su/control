<?php

namespace BristolSU\ControlDB\Models\Pivots;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Handles the linking of a user to a group
 */
class UserGroup extends Model
{
    use SoftDeletes;

    /**
     * Fillable attributes
     * 
     * @var array 
     */
    protected $fillable = [
        'user_id', 'group_id'
    ];
    
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Table to use
     * 
     * @var string 
     */
    public $table = 'control_group_user';
    
}