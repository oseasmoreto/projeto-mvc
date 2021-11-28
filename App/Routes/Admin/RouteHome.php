<?php 

namespace App\Routes\Admin;

use App\Middleware\Authenticate;
use App\Controllers\Admin\Home;
use App\Controllers\Admin\Usuario\Usuario;
use Slim\Http\Request;
use Slim\Http\Response;

/**
*  Classe responsável por gerenciar as rotas de home
*  @author Oseas Moreto
*/

class RouteHome{
  
  static protected $routes = [];
  
  /**
  * Método responsável por gerenciar as rotas de home
  * @method setRoute
  * @param  \Slim\App $app
  */
  public static function setRoute($app){
    
    self::$routes = [
      '',
      '/',
      '/home',
      '/index',
      '/dashboard',
    ];
    
    foreach (self::$routes  as $route) {
      $app->get($route, function (Request $request, Response $response, $args) use ($app) {
        $body = $response->getBody();
        $body->write((new Home)->index());
        
        return $response
        ->withBody($body)
        ->withStatus(200);
      })->setName('dashboard')->add(Authenticate::class);
    }

    $app->map(['GET', 'POST'],'/perfil/{id}', function (Request $request, $response, $args) use ($app) {
      return (new Usuario)->form($args['id']);
    })->setName('users')->add(Authenticate::class);
  }
}