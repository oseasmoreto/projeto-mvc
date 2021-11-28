<?php

namespace App\Core\OmExecute;

use App\Core\OmExecute\Generate\Colors;
use App\Core\OmExecute\Generate\Controller;
use App\Core\OmExecute\Generate\Model;
use App\Core\OmExecute\Generate\Route;
use App\Core\OmExecute\Generate\Service;
use App\Core\OmExecute\Generate\Template;
use App\Core\OmExecute\Generate\View;

/**
 * Classe responsável por gerenciar as ações em módulos de API
 * @author Oseas Moreto
 */

class Api {

    /**
     * Dados para criar cada entidade
     * @var array
     */
    private $dadosCriacao = [];

    /**
     * Método responsável por criar os módulos de API
     * @method criarApi
     * @param array $params
     * @return void
     */
    public function criarApi($params = []){

        if(!isset($params[0])) die((new Colors)->getColoredString("Insira o nome do Módulo de API", "yellow") . "\n");

        $this->dadosCriacao['modulo']   = $params[0];
        $this->dadosCriacao['package']  = (string)readline("Insira o Namespace (pode ser novo ou já existente): ");

        Model::setDadosModelApi($this->dadosCriacao);
        Route::setDadosRouteApi($this->dadosCriacao);
        
        $this->generateModuleApi($this->dadosCriacao);
    }

    /**
     * Método responsável por gerar o módulo API
     * @method generateModuleApi
     * @return void
     */
    public function generateModuleApi(){

        try {
            $this->createControllerApi();
            $this->createModelApi();
            $this->createRouteApi();
    
            die((new Colors)->getColoredString('Módulo de API criado com sucesso....',"light_green"));
        } catch (\Exception $e) {
            die((new Colors)->getColoredString('Erro ao criar o módulo de API: '.  $e->getMessage(),"red"). "\n");
        }
    }

    /**
     * Método responsável por setar o objeto do controller e criar
     * @method createControllerApi
     * @return void
     */
    public function createControllerApi(){
        $obController = new Controller;
        $obController->package    = $this->dadosCriacao['package'];
        $obController->controller = $this->dadosCriacao['modulo'];
        $obController->model      = $this->dadosCriacao['model'];
        $obController->createControllerApi();
    }

    /**
     * Método responsável por setar o objeto do model e criar
     * @method createModel
     * @return void
     */
    public function createModelApi(){
        $obModel = new Model;
        $obModel->model    = $this->dadosCriacao['model'];
        $obModel->package  = $this->dadosCriacao['package'];
        $obModel->modelPai = $this->dadosCriacao['modelPai'];
        $obModel->createModelApi();
    }

    /**
     * Método responsável por setar o objeto do model e criar
     * @method createRoute
     * @return void
     */
    public function createRouteApi(){
        $obRoute = new Route;
        $obRoute->package    = $this->dadosCriacao['package'];
        $obRoute->controller = $this->dadosCriacao['modulo'];
        $obRoute->route      = $this->dadosCriacao['rota'];
        $obRoute->aliasRoute = $this->dadosCriacao['nomeRota'];
        $obRoute->createRouteApi();
    }
}