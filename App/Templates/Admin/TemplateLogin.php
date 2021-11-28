<?php
namespace App\Templates\Admin;

use App\Templates\Admin\Modulos\TemplateLoad;
use stdClass;

/**
 * Classe responsável por gerenciar os templates da página de Login
 * @class TemplateHome
 * @author Oseas Moreto
 */
class TemplateLogin extends TemplateLoad{

    private $folder = 'admin/login';

    public function __construct(){
        //HERDA O CONSTRUCT PAI
        parent::__construct();

        $this->parameters           = new stdClass;
        $this->parameters->view     = $this->folder.'/index';
        $this->parameters->title    = 'Login';
        $this->parameters->routePage = PREFIX_DASHBOARD.'/login';
        $this->parameters->list     = [];

        $this->parameters->breadcrumb = [];
    }

    /**
     * Método responsável por renderizar a index
     * @method index
     * @return html/twig
     */
    public function index(){
        return $this->indexAdminDefault($this->parameters);
    }
}
