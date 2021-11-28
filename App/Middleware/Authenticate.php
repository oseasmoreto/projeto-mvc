<?php

namespace App\Middleware;

use App\Auth\Authenticate as Auth;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Classes\Funcoes\SessionControl;

/**
 * Classe responsável por tratar ações de autenticação do admin
 * @author Oseas Moreto
 */

class Authenticate{

    /**
     * Método mágico responsável pela validação de usuário logado
     * @method __invoke
     * @param Request  $request
     * @param Response $response
     * @param $next
     */
    public function __invoke(Request $request, Response $response, $next){
        SessionControl::start_session();
        $logado = true;

        //VALIDA USUARIO NA SESSÃO
        if (!isset($_SESSION['user'])) $logado = false;

        //RECUPERA O NOME DA ROTA
        $route = $request->getAttribute('route');

        //VALIDA ACESSO AS PÁGINAS
        $logado = Auth::logado($route->getName());

        if(!$logado){
            SessionControl::session_destroy();
            echo "<pre>"; print_r($logado); echo "</pre>"; exit;
            return $response->withStatus(302)->withHeader('Location', PREFIX_DASHBOARD.'/login');
        }
        
        $response = $next($request, $response);

        return $response;
    }
}