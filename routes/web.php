<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', 'AppController@index');

$router->group(['prefix' => 'api/v1'], function() use ($router) {

    // AUTH
    $router->group(['prefix' => 'auth'], function() use ($router) {
        $router->post('login', 'AuthController@login');
        $router->post('logout', 'AuthController@logout');
        $router->post('refresh', 'AuthController@refresh');
        $router->get('me', 'AuthController@me');
        $router->get('payoad', 'AuthController@payoad');

        // REGISTER
        $router->post('register', 'UserController@register');
    });

    //LOGGED
    $router->group(['middleware' => ['auth:api']], function() use ($router) {

        // USERS
        $router->group(['prefix' => 'users', 'middleware' => ['role:super|admin']], function() use ($router) {
            $router->get('/', ['middleware' => ['permission:user-list'], 'uses' => 'UserController@index']);
            $router->get('/{id}', ['middleware' => ['permission:user-list'], 'uses' => 'UserController@show']);
            $router->post('/', ['middleware' => ['permission:user-create'], 'uses' => 'UserController@store']);
            $router->put('/{id}', ['middleware' => ['permission:user-edit'], 'uses' => 'UserController@update']);
            $router->delete('/{id}', ['middleware' => ['permission:user-delete'], 'uses' => 'UserController@destroy']);
        });

        // ROLES
        $router->group(['prefix' => 'roles', 'middleware' => ['role:super|admin']], function() use ($router) {
            $router->get('/', ['middleware' => ['permission:role-list'], 'uses' => 'RoleController@index']);
            $router->get('/{id}', ['middleware' => ['permission:role-list'], 'uses' => 'RoleController@show']);
            $router->post('/', ['middleware' => ['permission:role-create'], 'uses' => 'RoleController@store']);
            $router->put('/{id}', ['middleware' => ['permission:role-edit'], 'uses' => 'RoleController@update']);
            $router->delete('/{id}', ['middleware' => ['permission:role-delete'], 'uses' => 'RoleController@destroy']);
        });

        // PERMISSIONS
        $router->group(['prefix' => 'permissions', 'middleware' => ['role:super|admin']], function() use ($router) {
            $router->get('/', ['middleware' => ['permission:permission-list'], 'uses' => 'PermissionController@index']);
            $router->get('/{id}', ['middleware' => ['permission:permission-list'], 'uses' => 'PermissionController@show']);
            $router->post('/', ['middleware' => ['permission:permission-create'], 'uses' => 'PermissionController@store']);
            $router->put('/{id}', ['middleware' => ['permission:permission-edit'], 'uses' => 'PermissionController@update']);
            $router->delete('/{id}', ['middleware' => ['permission:permission-delete'], 'uses' => 'PermissionController@destroy']);
        });

        // CPFS
        $router->group(['prefix' => 'cpf'], function() use ($router) {
            $router->get('/', ['middleware' => ['permission:cpf-list'], 'uses' => 'CpfController@index']);
            $router->get('/{cpf}', ['middleware' => ['permission:cpf-list'], 'uses' => 'CpfController@show']);
            $router->post('/', ['middleware' => ['permission:cpf-create'], 'uses' => 'CpfController@store']);
            $router->delete('/{cpf}', ['middleware' => ['permission:cpf-delete'], 'uses' => 'CpfController@destroy']);
        });

    });

});
