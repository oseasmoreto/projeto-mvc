<?php 

namespace App\Routes\Admin\Usuario;

use App\Middleware\Authenticate;
use App\Controllers\Admin\Usuario\GrupoAcesso;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 *  Classe responsável por gerenciar as rotas de grupo de acesso
 *  @author Oseas Moreto
 */

class RouteGrupoAcesso{

    static protected $routes = [];
    
    /**
     * Método responsável por gerenciar as rotas de grupo de acesso
     * @method setRoute
     * @param  \Slim\App $app
     */
    public static function setRoute($app){

        $app->get('/grupoacesso', function (Request $request, Response $response, $args) use ($app) {
            return (new GrupoAcesso)->index();
        })->setName('grupoacesso')->add(Authenticate::class);
        
        $app->map(['GET', 'POST'],'/grupoacesso/form', function (Request $request, $response, $args) use ($app) {
            return (new GrupoAcesso)->form();
        })->setName('grupoacesso')->add(Authenticate::class);
        
        $app->map(['GET', 'POST'],'/grupoacesso/form/{id}', function (Request $request, $response, $args) use ($app) {
            return (new GrupoAcesso)->form($args['id']);
        })->setName('grupoacesso')->add(Authenticate::class);
        
        $app->map(['GET', 'POST'],'/grupoacesso/save', function (Request $request, $response, $args) use ($app) {
            return (new GrupoAcesso)->save($request->getParsedBody());
        })->setName('grupoacesso')->add(Authenticate::class);
        
        $app->get('/grupoacesso/destroy/{id}', function ($request, $response, $args) use ($app) {
            return (new GrupoAcesso)->delete($args['id']);
        })->setName('grupoacesso')->add(Authenticate::class);
    }
}