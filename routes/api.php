<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Group')->group(function() {
    Route::apiResource('group', 'GroupController')->parameter('group', 'control_group');
    Route::apiResource('group.tag', 'GroupGroupTagController')->only(['index', 'update', 'destroy'])->parameters(['group' => 'control_group', 'tag' => 'control_group_tag']);
    Route::apiResource('group.user', 'GroupUserController')->only(['index', 'update', 'destroy'])->parameters(['group' => 'control_group', 'user' => 'control_user']);
    Route::apiResource('group.role', 'GroupRoleController')->only(['index'])->parameters(['group' => 'control_group', 'role' => 'control_role']);
});

Route::namespace('User')->group(function() {
    Route::apiResource('user', 'UserController')->parameter('user', 'control_user');
    Route::apiResource('user.tag', 'UserUserTagController')->only(['index', 'update', 'destroy'])->parameters(['user' => 'control_user', 'tag' => 'control_user_tag']);
    Route::apiResource('user.role', 'UserRoleController')->only(['index', 'update', 'destroy'])->parameters(['user' => 'control_user', 'role' => 'control_role']);
    Route::apiResource('user.group', 'UserGroupController')->only(['index', 'update', 'destroy'])->parameters(['user' => 'control_user', 'group' => 'control_group']);
});

Route::namespace('Role')->group(function() {
    Route::apiResource('role', 'RoleController')->parameter('role', 'control_role');
    Route::apiResource('role.tag', 'RoleRoleTagController')->only(['index', 'update', 'destroy'])->parameters(['role' => 'control_role', 'tag' => 'control_role_tag']);
    Route::apiResource('role.user', 'RoleUserController')->only(['index', 'update', 'destroy'])->parameters(['role' => 'control_role', 'user' => 'control_user']);
    Route::apiResource('role.group', 'RoleGroupController')->only(['index'])->parameters(['role' => 'control_role']);
    Route::apiResource('role.position', 'RolePositionController')->only(['index'])->parameters(['role' => 'control_role']);
});

Route::namespace('Position')->group(function() {
    Route::apiResource('position', 'PositionController')->parameter('position', 'control_position');
    Route::apiResource('position.tag', 'PositionTagController')->only(['index', 'update', 'destroy'])->
        parameters(['position' => 'control_position', 'tag' => 'control_position_tag']);
    Route::apiResource('position.role', 'PositionRoleController')->only(['index'])->parameters(['position' => 'position_role']);
});

Route::namespace('UserTag')->group(function() {
    Route::apiResource('user-tag', 'UserTagController')->parameters(['user-tag' => 'control_user_tag']);
    Route::apiResource('user-tag.user', 'UserTagUserController')->only(['index', 'update', 'destroy'])->parameters(['user-tag' => 'control_user_tag', 'user' => 'control_user']);
    Route::apiResource('user-tag.user-tag-category', 'UserTagUserTagCategoryController')->only(['index'])->parameters(['user-tag' => 'control_user_tag', 'user-tag-category' => 'control_user_tag_category']);
});

Route::namespace('UserTagCategory')->group(function() {
    Route::apiResource('user-tag-category', 'UserTagCategoryController')->parameters(['user-tag-category' => 'control_user_tag_category']);
    Route::apiResource('user-tag-category.user-tag', 'UserTagCategoryUserTagController')->only(['index'])->parameters(['user-tag-category' => 'control_user_tag_category']);
});

