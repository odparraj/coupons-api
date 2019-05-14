<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', '\Modules\Api\Http\Controllers\ApiController@changeLog');

/*Route::get('/', function () {
    $project = [
        'name' => 'Aliatu - API',
        'description' => 'Aliatu - API',
        'version' => '1.0.0',
        'company' => 'Zinobe',
        'versions' => [          
            '1.0.0' => 'Initial version'

        ]
    ];
    
    return view('welcome', ['project' => $project]);
});*/
