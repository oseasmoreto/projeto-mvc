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
 * Classe responsável por gerenciar as ações em módulos
 * @author Oseas Moreto
 */

class Module {

    /**
     * Dados para criar cada entidade
     * @var array
     */
    private $dadosCriacao = [];

    /**
     * Método responsável por criar os módulos
     * @method criarModulo
     * @param array $params
     * @return void
     */
    public function criarModulo($params = []){

        if(!isset($params[0])) die((new Colors)->getColoredString("Insira o nome do Módulo", "yellow") . "\n");

        $this->dadosCriacao['modulo']   = $params[0];
        $this->dadosCriacao['package']  = (string)readline("Insira o Namespace (pode ser novo ou já existente): ");
        $this->dadosCriacao['viewPath'] = strtolower($this->dadosCriacao['modulo']);

        Model::setDadosModel($this->dadosCriacao);
        Route::setDadosRoute($this->dadosCriacao);
        
        $this->generateModule($this->dadosCriacao);
    }

    /**
     * Método responsável por gerar o módulo
     * @method generateModule
     * @return void
     */
    public function generateModule(){

        try {
            $this->createController();
            if($this->dadosCriacao['criarEntidade'] == 's') $this->createModel();
            $this->createRoute();
            $this->createService();
            $this->createTemplate();
            $this->createView();
    
            die((new Colors)->getColoredString('Módulo criado com sucesso....',"light_green"));
        } catch (\Exception $e) {
            die((new Colors)->getColoredString('Erro ao criar o módulo: '.  $e->getMessage(),"red"). "\n");
        }
    }

    /**
     * Método responsável por setar o objeto do controller e criar
     * @method createController
     * @return void
     */
    public function createController(){
        $obController = new Controller;
        $obController->package    = $this->dadosCriacao['package'];
        $obController->controller = $this->dadosCriacao['modulo'];
        $obController->route      = $this->dadosCriacao['rota'];
        $obController->createController();
    }

    /**
     * Método responsável por setar o objeto do model e criar
     * @method createModel
     * @return void
     */
    public function createModel(){
        $obModel = new Model;
        $obModel->model   = $this->dadosCriacao['model'];
        $obModel->package = $this->dadosCriacao['package'];
        $obModel->tabela  = $this->dadosCriacao['table'];
        $obModel->pk      = $this->dadosCriacao['pk'];
        $obModel->createModel();
    }

    /**
     * Método responsável por setar o objeto do model e criar
     * @method createRoute
     * @return void
     */
    public function createRoute(){
        $obRoute = new Route;
        $obRoute->package    = $this->dadosCriacao['package'];
        $obRoute->controller = $this->dadosCriacao['modulo'];
        $obRoute->route      = $this->dadosCriacao['rota'];
        $obRoute->aliasRoute = $this->dadosCriacao['nomeRota'];
        $obRoute->createRoute();
    }

    /**
     * Método responsável por setar o objeto do model e criar
     * @method createRoute
     * @return void
     */
    public function createService(){
        $obService = new Service;
        $obService->package = $this->dadosCriacao['package'];
        $obService->service = 'Service'.$this->dadosCriacao['modulo'];
        $obService->model   = $this->dadosCriacao['model'];
        $obService->createService();
    }

    /**
     * Método responsável por setar o objeto do model e criar
     * @method createRoute
     * @return void
     */
    public function createTemplate(){
        $obTemplate           = new Template;
        $obTemplate->package  = $this->dadosCriacao['package'];
        $obTemplate->template = 'Template'.$this->dadosCriacao['modulo'];
        $obTemplate->model    = $this->dadosCriacao['model'];
        $obTemplate->route    = $this->dadosCriacao['rota'];
        $obTemplate->viewPath = $this->dadosCriacao['viewPath'];
        $obTemplate->createTemplate();
    }

    /**
     * Método responsável por setar o objeto da view e criar
     * @method createRoute
     * @return void
     */
    public function createView(){
        $obView           = new View;
        $obView->package  = $this->dadosCriacao['package'];
        $obView->viewPath = $this->dadosCriacao['viewPath'];
        $obView->createView();
    }
}