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

    //Roles
    Route::post('roles/{role}/sync-permissions', 'RolesController@syncPermissions');
    Route::get('roles/{role}/permissions', 'RolesController@rolePermissions');
    Route::apiResource('roles', 'RolesController');

    //Permissions
    Route::apiResource('permissions', 'PermissionsController');

    //Products
    Route::apiResource('products', 'ProductsController');
    
    Route::get('test',function(Request $request){

        $user = $request->user();
        Cart::restoreLastActiveCart($user);
        //Cart::setUser(Auth::user());
        $product = \Modules\Api\Entities\ProductModel::find(1);
        Cart::addItem($product,1); //Adds one product to the cart
        //dd( Cart::itemCount() );
        //dd( Cart::exists() );
    });

});
