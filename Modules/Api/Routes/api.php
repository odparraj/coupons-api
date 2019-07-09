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
    Route::put('me/products/{uuid}/sync-taxons', 'ProductsController@meProductsSyncTaxons');
    Route::get('me/products/{uuid}', 'ProductsController@meProductsShow');
    Route::get('me/products/{uuid}/taxons', 'ProductsController@meProductsTaxons');
    Route::delete('me/products/{uuid}', 'ProductsController@meProductsDestroy');

    Route::post('me/customers', 'CustomersController@meCustomersStore');
    Route::get('me/customers', 'CustomersController@meCustomersIndex');
    Route::put('me/customers/{uuid}', 'CustomersController@meCustomersUpdate');
    Route::get('me/customers/{uuid}', 'CustomersController@meCustomersShow');
    Route::delete('me/customers/{uuid}', 'CustomersController@meCustomersDestroy');

    Route::post('me/customers/{uuid}/quota-update', 'CustomersController@updateQuota');
    Route::post('me/customers/{uuid}/quota-change-active', 'CustomersController@changeActiveQuota');
    Route::get('me/customers/{uuid}/quota', 'CustomersController@getQuota');
    Route::get('me/customers/{uuid}/transactions', 'CustomersController@getTransactions');

    //Roles
    Route::post('roles/{role}/sync-permissions', 'RolesController@syncPermissions');
    Route::get('roles/{role}/permissions', 'RolesController@rolePermissions');
    Route::apiResource('roles', 'RolesController');
    Route::get('customer-roles', 'CustomersController@customerRoles');

    //Permissions
    Route::get('permissions-all', 'PermissionsController@getAll');
    Route::apiResource('permissions', 'PermissionsController');

    //Products
    Route::get('products', 'ProductsController@index');
    //Route::apiResource('products', 'ProductsController')->parameters(['products' => 'uuid']);

    //Taxonomies
    Route::apiResource('taxonomies', 'TaxonomiesController')->parameters(['taxonomies' => 'uuid']);
    Route::apiResource('taxons', 'TaxonsController')->parameters(['taxons' => 'uuid']);

    //Quotas
    Route::apiResource('quotas', 'QuotasController');

    Route::group(['middleware'=>['role:customer']] , function (){
        Route::get('me/quota', 'CustomersController@meQuota');
        Route::get('me/transactions', 'CustomersController@meTransactions');
        Route::post('me/checkout', 'CartController@checkout');
    });

});
