<?php

namespace App\Controllers\Admin;

use App\Templates\Admin\TemplateHome;
use \App\Classes\Funcoes\SessionControl;
use \App\Controllers\Admin\Common;

/**
 * Classe responsável por gerenciar a página da home
 *
 * @author oseas
 */
class Home extends Common{

    /**
     * Atributo de link da página
     */
    protected $pagelink = 'admin';

    /**
     * Método responsável por chamar o template da index da home
     * @return mixed
     */
    public function index(){
        SessionControl::start_session();
        return (new TemplateHome)->index();
    }
}
