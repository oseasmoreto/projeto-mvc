<?php
namespace App\Core;

use App\Routes\Admin;
use Slim\App as SlimApp;
use \App\Routes\Web;
use \App\Routes\Api;

/**
 * Classe responsável por manipular eventos de rota
 * @author Oseas Moreto
 */
class Routes {

    /**
     * Método responsável por iniciar as rotas
     * @method init
     * @return void
     */
    public static function init(){
        $app = new SlimApp([
            'settings' => [
                'displayErrorDetails' => APP_ENV == 'local'
            ]
        ]);

        Admin::init($app);
        Web::init($app);
        Api::init($app);

        $app->add(new \Tuupola\Middleware\CorsMiddleware([
            "origin" => ["*"],
            "methods" => ["GET", "POST", "PATCH", "DELETE", "OPTIONS"],    
            "headers.allow" => ["Origin", "Content-Type", "Authorization", "Accept", "ignoreLoadingBar", "X-Requested-With", "Access-Control-Allow-Origin"],
            "headers.expose" => [],
            "credentials" => true,
            "cache" => 0,        
        ]));

        $app->run();
    }
}

