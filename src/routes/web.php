<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


Route::group([
    'prefix' => 'api'
], function ($router) {
    Route::post('sign-in', 'AuthController@signIn');
    Route::post('register', 'AuthController@register');
    Route::post('recover-password', 'AuthController@forgotPassword');
    Route::patch('recover-password', ['as' => 'password.reset', 'uses' => 'AuthController@recoverPassword']);

    Route::group(['middleware' => 'auth'], function ($router) {
        Route::get('profile', 'AuthController@profile');
        Route::post('companies', 'CompanyController@create');
        Route::get('companies', 'CompanyController@index');
    });
});
