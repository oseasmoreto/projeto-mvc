<?php

namespace App\Routes\Api\Home;

use App\Core\Routes;
use Slim\Http\Response;
use App\Middleware\ApiAuthenticate;

/**
 *  Classe responsável por gerenciar as rotas de home
 *  @author Oseas Moreto
 */
class RouteApiHome extends Routes{
    
    /**
     * Método responsável por gerenciar as rotas de home
     * @method setRoute
     * @param  \Slim\App $app
     */
    public static function setRoute($app){
    }
}