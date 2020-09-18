<?php

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



$router->post('/login',"LoginController@doLogin");


//auth
$router->group(['prefix' => '/'], function () {
    Route::post('login',"LoginController@doLogin");
//    Route::post('login',                    'LoginController@login');
//    Route::get('logout',                    'LoginController@logout')->name('logout');
//    Route::post('logout',                   'LoginController@logout')->name('logout');
});

$router->group(['prefix' => '/admin', 'namespace' => "Admin","middleware"=>['auth','permission']], function () {
    Route::get('/refPass',"UserController@refreshPassword");
    Route::get('/user',"UserController@index");
});
