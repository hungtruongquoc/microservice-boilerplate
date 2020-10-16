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

$router->get('/', 'HealthCheckController@info');

$router->get('/_health', 'HealthCheckController@health');

$router->post('/jobs', 'JobController@create');
$router->get('/jobs/{id}', 'JobController@getStatus');
$router->get('/jobs', 'JobController@getNextJob');
