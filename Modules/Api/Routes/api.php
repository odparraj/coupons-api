<?php

use Illuminate\Http\Request;

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

Route::post('auth/login', 'UsersController@login');
Route::get('auth/logout', 'UsersController@logout')->middleware('auth:api');

Route::middleware('auth:api')->group(function () {

    //Users
    Route::apiResource('users', 'UsersController');

    //Roles
    Route::post('roles/{role}/sync-permissions', 'RolesController@syncPermissions');
    Route::apiResource('roles', 'RolesController');

    //Permissions
    Route::apiResource('permissions', 'PermissionsController');

});