<?php
namespace App\Templates\Admin;

use App\Templates\Admin\Modulos\TemplateLoad;
use stdClass;

class TemplateError extends TemplateLoad{

    private $folder    = 'admin/error';

    public function __construct(){
        //HERDA O CONSTRUCT PAI
        parent::__construct();

        $this->parameters           = new stdClass;
        $this->parameters->view     = $this->folder.'/index';
        $this->parameters->title    = 'Dashboard';
        $this->parameters->routePage = PREFIX_DASHBOARD.'/dashboard';
        $this->parameters->list     = [];

        $this->parameters->breadcrumb = [];
    }

    /**
     * Método responsável por renderizar a página
     * @method error404
     * @return html/twig
     */
    public function error404(){  
        $this->parameters->view = $this->folder.'/404';
        return $this->indexAdminDefault($this->parameters);
    }
    
    /**
     * Método responsável por renderizar a página
     * @method error500
     * @return html/twig
     */
    public function error500() {
        $this->parameters->view = $this->folder.'/500';
        return $this->indexAdminDefault($this->parameters);
    }
}
