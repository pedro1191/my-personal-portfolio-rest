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

    // Message
    $api->post('/messages', ['uses' => 'MessageController@store', 'as' => 'api.messages.store']);

    // Email
    $api->post('/emails/send', ['uses' => 'EmailController@send', 'as' => 'api.emails.send']);
});
