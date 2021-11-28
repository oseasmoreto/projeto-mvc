<?php

namespace App\Core\OmExecute\Generate;

/**
 * Classe responsável por gerenciar as ações em routes
 * @author Oseas Moreto
 */

class Route {

    /**
     * Route
     * @var route
     */
    public $route = null;

    /**
     * Package
     * @var string
     */
    public $package = null;

    /**
     * Alias Route
     * @var string
     */
    public $aliasRoute = null;

    /**
     * Controller
     * @var controller
     */
    public $controller = null;

    /**
     * Método responsável por criar o route
     * @method createRoute
     * @return bool
     */
    public function createRoute(){
       
        $variables = [
            'package'       => $this->package,
            'controller'    => $this->controller,
            'router'        => 'Route'.$this->controller,
            'useController' => 'use App\Controllers\\'.$this->package.'\\'.$this->controller,
            'rota'          => $this->route,
            'nomeRota'      => $this->aliasRoute
        ];

        //INSTANCIA O OBJETO FILE
        $obFile = new File;
        $obFile->package  = $this->package;
        $obFile->setPath();

        $obFile->createFile($variables['router'].'.php', 'route', 'route.default',$variables);

        return true;
    }

    /**
     * Método responsável por criar o route
     * @method createRouteApi
     * @return bool
     */
    public function createRouteApi(){
       
        $variables = [
            'package'       => $this->package,
            'controller'    => $this->controller,
            'router'        => 'RouteApi'.$this->controller,
            'useController' => 'use App\Controllers\\'.$this->package.'\\'.$this->controller,
            'rota'          => $this->route,
            'nomeRota'      => $this->aliasRoute
        ];

        //INSTANCIA O OBJETO FILE
        $obFile = new File;
        $obFile->package  = $this->package;
        $obFile->setPath();

        $obFile->createFile($variables['router'].'.php', 'route', 'api\\route.default',$variables);

        return true;
    }

    /**
     * Método responsável por setar os dados de route
     * @method static setDadosRoute()
     * @param array $dadosCadastro
     * @return void
     */
    public static function setDadosRoute(&$dadosCadastro){
        $dadosCadastro['rota']     = (string)readline("Insira a Rota do módulo: ");
        $dadosCadastro['nomeRota'] = (string)readline("Insira o Alias da Rota do módulo: ");
    }

    /**
     * Método responsável por setar os dados de route
     * @method static setDadosRouteApi()
     * @param array $dadosCadastro
     * @return void
     */
    public static function setDadosRouteApi(&$dadosCadastro){
        $dadosCadastro['rota']     = (string)readline("Insira a Rota do módulo: ");
        $dadosCadastro['nomeRota'] = (string)readline("Insira o Alias da Rota do módulo: ");
    }
}