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

$router->group(['prefix' => 'api'], function () use ($router) {

    // User
    $router->post('user/createUser',                      ['uses' => 'UserController@createUser']);

    // Authorization
    $router->post('authorization/loginToPlatform',        ['uses' => 'AuthorizationController@loginToPlatform']);
    $router->get('authorization/checkIfUserSessionExists',['uses' => 'AuthorizationController@checkIfUserSessionExists']);
    $router->delete('authorization/logoutFromPlatform',   ['uses' => 'AuthorizationController@logoutFromPlatform']);

  });
