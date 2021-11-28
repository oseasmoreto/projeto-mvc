<?php

namespace App\Routes;

use App\Controllers\Admin\Error\Error;
use App\Controllers\Admin\Error\NotFound;
use App\Routes\Admin\RouteLogin;
use App\Routes\Admin\RouteHome;
use App\Routes\Admin\Usuario\RouteGrupoAcesso;
use App\Routes\Admin\Usuario\RouteMenu;
use App\Routes\Admin\Usuario\RouteUsuario;

class Admin{
  
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
    
    $app->group(PREFIX_DASHBOARD, function () use ($app) {
      //rotas index
      RouteHome::setRoute($app);
      //rotas login
      RouteLogin::setRoute($app);
      //rotas menu
      RouteMenu::setRoute($app);
      //rotas grupo de acesso
      RouteGrupoAcesso::setRoute($app);
      //rotas usuarios
      RouteUsuario::setRoute($app);
    });
  }
}
