<?php

namespace App\Core\OmExecute\Generate;

/**
 * Classe responsável por gerenciar as ações em controllers
 * @author Oseas Moreto
 */

class Controller {

    /**
     * Controller
     * @var controller
     */
    public $controller = null;

    /**
     * Package
     * @var string
     */
    public $package = null;

    /**
     * Route
     * @var route
     */
    public $route = null;

    /**
     * Model
     * @var string
     */
    public $model = null;

    /**
     * Método responsável por criar o controller
     * @method createController
     * @return bool
     */
    public function createController(){
       
        $variables = [
            'package'     => $this->package,
            'controller'  => $this->controller,
            'template'    => 'Template'.$this->controller,
            'service'     => 'Service'.$this->controller,
            'useTemplate' => 'use App\Templates\\'.$this->package.'\\Template'.$this->controller,
            'useService'  => 'use App\Services\\'.$this->package.'\\Service'.$this->controller,
            'rota'        => '/'.$this->route
        ];

        //INSTANCIA O OBJETO FILE
        $obFile = new File;
        $obFile->package  = $this->package;
        $obFile->setPath();

        $obFile->createFile($this->controller.'.php', 'controller', 'controller.default',$variables);

        return true;
    }

    /**
     * Método responsável por criar o controller
     * @method createControllerApi
     * @return bool
     */
    public function createControllerApi(){
        $package = explode('\\', $this->package);
        $modelName = end($package).$this->model;
       
        $variables = [
            'package'     => $this->package,
            'controller'  => $this->controller,
            'model'       => $modelName,
            'useModel'    => 'use \App\Models\\'.$this->package.'\\'.$this->model.' as '.$modelName.';'
        ];

        //INSTANCIA O OBJETO FILE
        $obFile = new File;
        $obFile->package  = $this->package;
        $obFile->setPath();

        $obFile->createFile($this->controller.'.php', 'controller', 'api\\controller.default',$variables);

        return true;
    }
}