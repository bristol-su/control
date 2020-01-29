<?php

namespace BristolSU\ControlDB\Models\Pivots;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Handles the linking between user and role
 */
class UserRole extends Model
{
    use SoftDeletes;

    /**
     * Fillable attributes
     * 
     * @var array 
     */
    protected $fillable = [
        'user_id', 'role_id'
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
    public $table = 'control_role_user';
    
}