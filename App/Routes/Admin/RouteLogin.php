<?php 

namespace App\Routes\Admin;

use App\Controllers\Admin\Login;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 *  Classe responsável por gerenciar as rotas de login
 *  @author Oseas Moreto
 */

class RouteLogin{
    /**
     * Método responsável por gerenciar as rotas de login
     * @method setRoute
     * @param  \Slim\App $app
     */
    public static function setRoute($app){
        $app->get('/login', function (Request $request, Response $response, $args) use ($app) {
            
            $body = $response->getBody();
            $body->write((new Login)->index()); 
            
            return $response
                ->withBody($body)
                ->withStatus(200);
        });

        $app->post('/login/logar', function (Request $request, Response $response, $args) use ($app) {
            $return = (new Login)->logar($request->getParsedBody());
            $body   = $response->getBody();
            $body->write(json_encode($return));

            return $response
                ->withBody($body)
                ->withHeader('Content-type', 'application/json')
                ->withStatus(200);
        });

        $app->get('/logout', function (Request $request, Response $response, $arg) use ($app) {
            (new Login)->logout();
            return $response->withRedirect(PREFIX_DASHBOARD.'/login', 301);
        });
    }
}