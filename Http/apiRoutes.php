<?php

use Illuminate\Routing\Router;

$router->group(['prefix' =>'/igamification/v1'], function (Router $router) {
    $router->apiCrud([
      'module' => 'igamification',
      'prefix' => 'categories',
      'controller' => 'CategoryApiController',
      //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);
    $router->apiCrud([
      'module' => 'igamification',
      'prefix' => 'activities',
      'controller' => 'ActivityApiController',
      //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);

    //
    $router->group(['prefix' => 'activity-user'], function (Router $router) {
      $router->get('/', [
        'as' => 'api.igamification.activity-user.get.items.by',
        'uses' => 'ActivityUserApiController@index',
        'middleware' => ['auth:api']
      ]);
    });

// append


});
