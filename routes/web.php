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

$router->get('/', function () {
    return "Hello from Pedro de Almeida's Portfolio!";
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'middleware' => ['api.throttle'],
    'limit' => 100,
    'expires' => 5,
    'prefix' => 'api/v1',
    'namespace' => 'App\Http\Controllers\V1',
], function ($api) {

    /**
     * Unauthenticated Routes
     */

    // Auth
    $api->post('/auth/login', ['uses' => 'AuthController@login', 'as' => 'api.auth.login']);

    // Message
    $api->post('/messages', ['uses' => 'MessageController@store', 'as' => 'api.messages.store']);

    // Project
    $api->get('/projects', ['uses' => 'ProjectController@index', 'as' => 'api.projects.index']);
    $api->get('/projects/{id}', ['uses' => 'ProjectController@show', 'as' => 'api.projects.show']);

    /**
     * Authenticated Routes
     */
    $api->group([
        'middleware' => ['api.auth'],
    ], function ($api) {

        // Auth
        $api->get('/auth/me', ['uses' => 'AuthController@me', 'as' => 'api.auth.me']);
        $api->put('/auth/refresh', ['uses' => 'AuthController@refresh', 'as' => 'api.auth.refresh']);
        $api->delete('/auth/logout', ['uses' => 'AuthController@logout', 'as' => 'api.auth.logout']);

        // Email
        $api->post('/emails/send', ['uses' => 'EmailController@send', 'as' => 'api.emails.send']);

        // Project
        $api->post('/projects', ['uses' => 'ProjectController@store', 'as' => 'api.projects.store']);
        $api->put('/projects/{id}', ['uses' => 'ProjectController@update', 'as' => 'api.projects.update']);
        $api->delete('/projects/{id}', ['uses' => 'ProjectController@destroy', 'as' => 'api.projects.destroy']);
    });
});
