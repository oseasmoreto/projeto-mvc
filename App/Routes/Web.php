<?php

namespace App\Routes;

use App\Controllers\Admin\Error\Error;
use App\Controllers\Admin\Error\NotFound;
use Slim\Http\Request;
use Slim\Http\Response;

class Web{
  
  /**
  * Método responsável por iniciar as rotas
  * @method init
  * @param  \Slim\App $app
  */
  public static function init(&$app){
    
    if(APP_ENV != 'local') {
      $app->getContainer()['errorHandler'] = function ($c) {
        return new Error();
      };
    }
    
    unset($app->getContainer()['notFoundHandler']);
    $app->getContainer()['notFoundHandler'] = function ($c) {
      return function ($request, $response) use ($c) {
        $response = new \Slim\Http\Response(404);
        return $response->write(NotFound::error404());
      };
    };
    
    $app->get('/', function (Request $request, Response $response, $args) use ($app) {
      $body = $response->getBody();
      $body->write('home');
      
      return $response
      ->withBody($body)
      ->withStatus(200);
    })->setName('home');
  }
}
