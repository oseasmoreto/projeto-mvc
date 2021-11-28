<?php

namespace App\Middleware;

use App\Auth\Authenticate as Auth;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Core\JWTWrapper;

/**
 * Classe responsável por tratar ações de autenticação do admin
 * @author Oseas Moreto
 */

class ApiAuthenticate{

    /**
     * Método mágico responsável pela validação de token da API
     * @method __invoke
     * @param Request  $request
     * @param Response $response
     * @param $next
     */
    public function __invoke(Request $request, Response $response, $next){
        $authorization = current($request->getHeaders()['HTTP_AUTHORIZATION']);
        list($jwt) = sscanf($authorization, 'Bearer %s');
        
        $body = $response->getBody();

        if(!$jwt){
            // nao foi possivel extrair token do header Authorization
            $body->write(json_encode([
                'message' => 'Acesso negado, token inválido.',
                'code'    => 401,
                'body'    => []
            ]));
            // nao foi possivel decodificar o token jwt
            return $response->withStatus(401)
            ->withHeader('Content-type', 'application/json')
            ->withBody($body);

        }
 
        try {
            $jwt = JWTWrapper::decode($jwt);
        } catch(\Exception $ex) {
            $body->write(json_encode([
                'message' => 'Acesso negado, token inválido.',
                'code'    => 401,
                'body'    => []
            ]));
            // nao foi possivel decodificar o token jwt
            return $response->withStatus(401)
            ->withHeader('Content-type', 'application/json')
            ->withBody($body);
        }
        
        $response = $next($request, $response);

        return $response;
    }
}