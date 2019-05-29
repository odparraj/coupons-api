<?php

use Illuminate\Http\Request;
use Vanilo\Cart\Facades\Cart;

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
    Route::post('users/{user}/sync-roles', 'UsersController@syncRoles');
    Route::get('users/{user}/roles','UsersController@userRoles');
    Route::apiResource('users', 'UsersController');
    
    //Me
    Route::get('me/roles', 'UsersController@meRoles');
    Route::get('me/cart', 'CartController@index');
    Route::post('me/cart', 'CartController@addProduct');
    Route::delete('me/cart', 'CartController@removeProduct');
    Route::post('me/products', 'ProductsController@meProductsStore');
    Route::get('me/products', 'ProductsController@meProductsIndex');
    Route::put('me/products/{uuid}', 'ProductsController@meProductsUpdate');
    Route::get('me/products/{uuid}', 'ProductsController@meProductsShow');
    Route::delete('me/products/{uuid}', 'ProductsController@meProductsDestroy');

    //Roles
    Route::post('roles/{role}/sync-permissions', 'RolesController@syncPermissions');
    Route::get('roles/{role}/permissions', 'RolesController@rolePermissions');
    Route::apiResource('roles', 'RolesController');

    //Permissions
    Route::apiResource('permissions', 'PermissionsController');

    //Products
    Route::get('products', 'ProductsController@index');
    //Route::apiResource('products', 'ProductsController')->parameters(['products' => 'uuid']);

    //Taxonomies
    Route::apiResource('taxonomies', 'TaxonomiesController')->parameters(['taxonomies' => 'uuid']);
    Route::apiResource('taxons', 'TaxonsController')->parameters(['taxons' => 'uuid']);

});
