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

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->get(
    '/hello/{name}',
    [
        'middleware' => 'hello',
        function ($name) use ($app) {
            return "Hello {$name}";
        }
    ]
);

$app->get('/ads', 'AdsController@index'); // Get all the ads
$app->post('/ads', 'AdsController@store'); // Create a new ads
//$app->get('/ads/{id:[\d]+}', 'AdsController@show'); // Get an ads (id --- integer will match)
$app->get(
    '/ads/{id:[\d]+}',
    [
        'as' => 'ads.show',
        'uses' => 'AdsController@show'
    ]
); // Get an ads (id --- integer will match)
$app->put('/ads/{id:[\d]+}', 'AdsController@update'); // Update an ads (id --- integer will match)
$app->delete('/ads/{id:[\d]+}', 'AdsController@destroy'); // Delete an ads (id --- integer will match)