<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
$api = app('Dingo\Api\Routing\Router');

Route::get('/', function () {
    return view('welcome');
});

$api = app('Dingo\Api\Routing\Router');


$api->version('v1', function($api){
    $api->get('users/{user_id}/roles/{role_name}', 'App\Http\Controllers\HomeController@attachUserRole');
    $api->get('users/{user_id}/roles', 'App\Http\Controllers\HomeController@getUserRole');


    $api->post('role/permission/add', 'App\Http\Controllers\HomeController@attachPermission');
    $api->get('role/{roleParam}/permissions/', 'App\Http\Controllers\HomeController@getPermissions');

    $api->post('authenticate', 'App\Http\Controllers\Auth\AuthController@authenticate');

});

// $api->version('v1', function ($api) {
//   Route::group(['prefix' => 'api'], function () {
//
//     //Route::get('hello', 'HomeController@index');
//     //Route::get('users/{user_id}/roles/{role_name}', 'HomeController@attachUserRole');
//     //Route::get('users/{user_id}/roles', 'HomeController@getUserRole');
//
//     //Route::post('role/permission/add', 'HomeController@attachPermission');
//     //Route::get('role/{roleParam}/permissions/', 'HomeController@getPermissions');
//
//     //Route::post('authenticate', 'Auth\AuthController@authenticate');
//
//     });
// });

  $api->version('v1', ['middleware' => 'api.auth'], function($api){
    $api->get('users', 'App\Http\Controllers\Auth\AuthController@index');
    $api->get('user', 'App\Http\Controllers\Auth\AuthController@show');
    $api->get('token', 'App\Http\Controllers\Auth\AuthController@getToken');
    $api->post('delete', 'App\Http\Controllers\Auth\AuthController@destroy');
});
