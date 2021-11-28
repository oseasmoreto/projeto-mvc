<?php

namespace App\Core\OmExecute\Generate;

/**
 * Classe responsável por gerenciar as ações em views
 * @author Oseas Moreto
 */

class View {

    /**
     * Package
     * @var string
     */
    public $package = null;

    /**
     * Pasta das views
     * @var string
     */
    public $viewPath = null;

    /**
     * Método responsável por criar as views
     * @method createView
     * @return bool
     */
    public function createView(){

        //INSTANCIA O OBJETO FILE
        $obFile = new File;
        $obFile->package  = $this->package;
        $obFile->viewPath = $this->viewPath;
        $obFile->setPath();

        $obFile->createFile('form.twig', 'view', 'views\form.default',[]);
        $obFile->createFile('list.twig', 'view', 'views\list.default',[]);

        return true;
    }
}