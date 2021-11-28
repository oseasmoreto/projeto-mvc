<?php 

namespace App\Routes\Admin\Usuario;

use App\Middleware\Authenticate;
use App\Controllers\Admin\Usuario\Usuario;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 *  Classe responsável por gerenciar as rotas de user
 *  @author Oseas Moreto
 */

class RouteUsuario{

    static protected $routes = [];
    
    /**
     * Método responsável por gerenciar as rotas de user
     * @method setRoute
     * @param  \Slim\App $app
     */
    public static function setRoute($app){

        $app->get('/users', function (Request $request, Response $response, $args) use ($app) {
            return (new Usuario)->index();
        })->setName('users')->add(Authenticate::class);
        
        $app->map(['GET', 'POST'],'/users/form', function (Request $request, $response, $args) use ($app) {
            return (new Usuario)->form();
        })->setName('users')->add(Authenticate::class);
        
        $app->map(['GET', 'POST'],'/users/form/{id}', function (Request $request, $response, $args) use ($app) {
            return (new Usuario)->form($args['id']);
        })->setName('users')->add(Authenticate::class);
        
        $app->map(['GET', 'POST'],'/users/save', function (Request $request, $response, $args) use ($app) {
            return (new Usuario)->save($request->getParsedBody());
        })->setName('users')->add(Authenticate::class);
        
        $app->get('/users/destroy/{id}', function ($request, $response, $args) use ($app) {
            $id = $args['id'];  
            return (new Usuario)->delete($id);
        })->setName('users')->add(Authenticate::class);
    }
}