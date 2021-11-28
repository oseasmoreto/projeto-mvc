<?php

namespace App\Core\OmExecute\Generate;

/**
 * Classe responsável por gerenciar as ações em services
 * @author Oseas Moreto
 */

class Service {

    /**
     * Service
     * @var service
     */
    public $service = null;

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
     * Método responsável por criar o service
     * @method createService
     * @return bool
     */
    public function createService(){
       
        $variables = [
            'package'  => $this->package,
            'service'  => $this->service,
            'useModel' => 'use App\Models\\'.$this->package.'\\'.$this->model,
            'model'    => $this->model
        ];

        //INSTANCIA O OBJETO FILE
        $obFile = new File;
        $obFile->package = $this->package;
        $obFile->setPath();

        $obFile->createFile($this->service.'.php', 'service', 'service.default',$variables);

        return true;
    }
}