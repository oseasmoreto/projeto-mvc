<?php

namespace App\Core\OmExecute\Generate;

/**
 * Classe responsável por gerenciar as ações em templates
 * @author Oseas Moreto
 */

class Template {

    /**
     * Template
     * @var template
     */
    public $template = null;

    /**
     * Package
     * @var string
     */
    public $package = null;

    /**
     * Controller
     * @var controller
     */
    public $controller = null;

    /**
     * Model
     * @var model
     */
    public $model = null;

    /**
     * Route
     * @var route
     */
    public $route = null;

    /**
     * Pasta das views
     * @var string
     */
    public $viewPath = null;

    /**
     * Método responsável por criar o template
     * @method createTemplate
     * @return bool
     */
    public function createTemplate(){
       
        $variables = [
            'package'  => $this->package,
            'template' => $this->template,
            'useModel' => 'use App\Models\\'.$this->package.'\\'.$this->model,
            'model'    => $this->model,
            'viewPath' => $this->viewPath,
            'rota'     => '/'.$this->route
        ];

        //INSTANCIA O OBJETO FILE
        $obFile = new File;
        $obFile->package  = $this->package;
        $obFile->viewPath = $this->viewPath;
        $obFile->setPath();

        $obFile->createFile($this->template.'.php', 'template', 'template.default',$variables);

        return true;
    }
}