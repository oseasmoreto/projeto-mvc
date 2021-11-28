<?php
namespace App\Templates\Admin;

use App\Templates\Admin\Modulos\TemplateLoad;
use stdClass;

/**
 * Classe responsável por gerenciar os templates da Home
 * @class TemplateHome
 * @author Oseas Moreto
 */

class TemplateHome extends TemplateLoad{

    public $parameters = null;
    private $folder    = 'admin/home';

    public function __construct(){
        //HERDA O CONSTRUCT PAI
        parent::__construct();

        $this->parameters           = new stdClass;
        $this->parameters->view     = $this->folder.'/index';
        $this->parameters->title    = 'Dashboard';
        $this->parameters->routePage = PREFIX_DASHBOARD.'/dashboard';
        $this->parameters->list     = [];

        $breadcrumb = [];
        
        $breadcrumb[0]['url']    = '#';
        $breadcrumb[0]['label']  = 'Dashboard';
        $breadcrumb[0]['active'] = true;

        $this->parameters->breadcrumb = $breadcrumb;
    }
    
    /**
     * Método responsável por renderizar a index da home
     * @method index
     * @return html/twig
     */
    public function index(){ 
        return $this->indexAdminDefault($this->parameters);
    }
}
