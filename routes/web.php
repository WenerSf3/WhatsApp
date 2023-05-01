<?php

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->get('list', 'UserController@AllUsers');
        $router->post('create', 'UserController@Create');
        $router->put('update/{id}', 'UserController@Update');
        $router->put('disable/{id}', 'UserController@Disable');
        $router->put('enable/{id}', 'UserController@Enable');
        $router->delete('delete/{id}', 'UserController@Delete');
    });
    $router->group(['prefix' => 'chat'], function () use ($router) {
        $router->get('list', 'UserController@AllUsers');
        $router->post('create', 'UserController@Create');
        $router->put('update/{id}', 'UserController@Update');
        $router->put('disable/{id}', 'UserController@Disable');
    });
});
