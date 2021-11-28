<?php 

namespace App\Routes\Admin\Usuario;

use App\Middleware\Authenticate;
use App\Controllers\Admin\Usuario\Menu;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 *  Classe responsável por gerenciar as rotas de menu
 *  @author Oseas Moreto
 */

class RouteMenu{

    static protected $routes = [];
    
    /**
     * Método responsável por gerenciar as rotas de menu
     * @method setRoute
     * @param  \Slim\App $app
     */
    public static function setRoute($app){

        $app->get('/menus', function (Request $request, Response $response, $args) use ($app) {
            return (new Menu)->index();
        })->setName('menus')->add(Authenticate::class);
        
        $app->map(['GET', 'POST'],'/menus/form', function (Request $request, $response, $args) use ($app) {
            return (new Menu)->form();
        })->setName('menus')->add(Authenticate::class);
        
        $app->map(['GET', 'POST'],'/menus/form/{id}', function (Request $request, $response, $args) use ($app) {
            return (new Menu)->form($args['id']);
        })->setName('menus')->add(Authenticate::class);
        
        $app->map(['GET', 'POST'],'/menus/save', function (Request $request, $response, $args) use ($app) {
            return (new Menu)->save($request->getParsedBody());
        })->setName('menus')->add(Authenticate::class);
        
        $app->get('/menus/destroy/{id}', function ($request, $response, $args) use ($app) {
            $id = $args['id'];  
            return (new Menu)->delete($id);
        })->setName('menus')->add(Authenticate::class);
    }
}