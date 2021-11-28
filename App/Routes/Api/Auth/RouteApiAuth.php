<?php

namespace App\Routes\Api\Auth;

use App\Controllers\Api\Auth;
use App\Core\Routes;
use Slim\Http\Response;
use App\Middleware\ApiAuthenticate;

/**
 *  Classe responsável por gerenciar as rotas de home
 *  @author Oseas Moreto
 */
class RouteApiAuth extends Routes{
    
    /**
     * Método responsável por gerenciar as rotas de home
     * @method setRoute
     * @param  \Slim\App $app
     */
    public static function setRoute($app){
        /**
         * Rota de verificação se a API está ativa
         */
        $app->post('/auth', function ($request, $response, $args) use ($app) {
            $bodyRequest  = $request->getParsedBody();
            $bodyResponse = $response->getBody();
            
            $retorno = (new Auth)->autenticar($bodyRequest);
            $bodyResponse->write(json_encode($retorno));
            
            return $response
                ->withBody($bodyResponse)
                ->withHeader('Content-type', 'application/json')
                ->withStatus($retorno['code']);
        });

        /**
         * Rota de verificação se a API está ativa
         */
        $app->get('/ping', function ($request, $response, $args) use ($app) {
            $body = $response->getBody();
            $body->write(json_encode(['ping' => 'pong']));

            return $response
                ->withBody($body)
                ->withHeader('Content-type', 'application/json')
                ->withStatus(200);
        })->add(ApiAuthenticate::class);
    }
}