<?php

namespace App\Routes;

use App\Routes\Api\Auth\RouteApiAuth;
use App\Routes\Api\Home\RouteApiHome;
use Slim\App;

/**
 * Classe responsável por agrupar as rotas de API
 * @author Oseas Moreto
 */
class Api{
    /**
     * Método responsável por iniciar as rotas
     * @method init
     * @param  \Slim\App $app
     */
    public static function init(&$app){

        $app->group('/api/v1', function (App $app) {
            RouteApiHome::setRoute($app);
            RouteApiAuth::setRoute($app);
        });
    }
}
