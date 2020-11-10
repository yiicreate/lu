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

$router->group([ 'prefix' => '/api' ], function ($router) {
    $router->post('login', "LoginController@doLogin");
    //需要验证登录的
    $router->group([ 'prefix' => '/admin', 'namespace' => "Admin", "middleware" => [ 'auth', 'permission' ] ],
        function ($router) {
            //管理员
            $router->group([ 'prefix' => 'user' ], function () use ($router) {
                $router->get('refPass', "UserController@refreshPassword");
                $router->get('self', "UserController@getUser");
                $router->get('list', "UserController@getlist");
                $router->get('logout', 'UserController@logout');


                $router->post('lists', "UserController@getlists");
                $router->post('ad', "UserController@setOne");
                $router->post('up', "UserController@setOneFId");
                $router->post('resPass', "UserController@resetPassword");
            });



        });
});
