<?php

use App\Helper\Token;
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


// Guest
$app->group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\v1', 'middleware' => ['xss', 'cors']], function($app)
{   

    $app->GET('/', function () use ($app) {
        return 'index';
    });
    $app->POST('auth/login', 'AuthController@login');

    $app->get('examples/token', 'ExampleController@token');
    $app->get('examples', 'ExampleController@index');
    $app->get('examples/{id}', 'ExampleController@view');
    
    
});

// Authorization
$app->group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\v1', 'middleware' => ['rest', 'xss', 'cors']], function($app)
{
    $app->post('examples', 'ExampleController@create');
    $app->put('examples/{id}', 'ExampleController@update');
    $app->delete('examples/{id}', 'ExampleController@destory');
    
    $app->POST('auth/create', 'AuthController@create');

    $app->get('syslogs', 
        [
            'uses'       => 'SyslogController@search', 
            // 'middleware' => 'acl:*:read'
        ]);

    // ******************************accounts********************************
    $app->POST('accounts', 
        [
            'uses' => 'AccountController@create', 
            'middleware' => 'acl:accounts:create'
        ]);

    $app->GET('accounts/{id}', 
        [
            'uses'       => 'AccountController@view', 
            'middleware' => 'acl:accounts:read'
        ]);

    // $APP->get('accounts/me', 
    //     [
    //         'uses'       => 'AccountController@me', 
    //         // 'middleware' => 'acl:accounts:read'
    //     ]);

    $app->PUT('accounts/me', 
        [
            'uses'       => 'AccountController@updateme', 
            // 'middleware' => 'acl:accounts:read'
        ]);

    $app->GET('accounts', 
        [
            'uses'       => 'AccountController@index', 
            'middleware' => 'acl:accounts:read'
        ]);

    $app->PUT('accounts/{id}', 
        [
            'uses' => 'AccountController@update', 
            'middleware' => 'acl:accounts:update'
        ]);

    // ******************************Role********************************
        $app->GET('roles', 
            [
                'uses' => 'RoleController@index', 
                'middleware' => 'acl:roles:read'
            ]);
        
        $app->GET('roles/{id}', 
            [
                'uses' => 'RoleController@view', 
                'middleware' => 'acl:roles:read'
            ]);

        $app->POST('roles', 
            [
                'uses' => 'RoleController@create', 
                'middleware' => 'acl:roles:create'
            ]);

        $app->PUT('roles/{id}', 
            [
                'uses' => 'RoleController@update', 
                'middleware' => 'acl:roles:update'
            ]);

        $app->DELETE('roles/{id}', 
            [
                'uses' => 'RoleController@destory', 
                'middleware' => 'acl:roles:delete'
            ]);

        $app->PUT('roles/{id}/permissions', 
            [
                'uses' => 'RoleController@changepermissions', 
                'middleware' => 'acl:roles:update'
            ]);


    // ******************************Permission********************************

        $app->get('permissions', 
            [
                'uses'       => 'PermissionController@index', 
                'middleware' => 'acl:permissions:read'
            ]);

        $app->get('permissions/{id}', 
            [
                'uses'       => 'PermissionController@view', 
                'middleware' => 'acl:permissions:read'
            ]);

    // ******************************Syslog********************************

        $app->get('syslog', 
            [
                'uses'       => 'SyslogController@index', 
            ]);
});