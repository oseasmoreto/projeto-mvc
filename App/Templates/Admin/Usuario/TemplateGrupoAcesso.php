<?php
namespace App\Templates\Admin\Usuario;

use App\Templates\Admin\Modulos\TemplateLoad;
use App\Models\Usuario\AccessMenu as Menu;
use App\Models\Usuario\AccessGroup as GrupoAcesso;
use stdClass;

/**
 * Classe responsável por gerenciar os templates da GrupoAcesso
 * @class TemplateHome
 * @author Oseas Moreto
 */

class TemplateGrupoAcesso extends TemplateLoad{

    public $parameters = null;
    private $folder    = 'admin/usuario/grupo-acesso';

    public function __construct(){
        //HERDA O CONSTRUCT PAI
        parent::__construct();

        $this->parameters           = new stdClass;
        $this->parameters->adds     = new stdClass;
        $this->parameters->view     = $this->folder.'/list';
        $this->parameters->title    = 'Grupo de Acesso';
        $this->parameters->routePage = PREFIX_DASHBOARD.'/grupoacesso';
        $this->parameters->list     = [];

        $breadcrumb = [];
        
        $breadcrumb[0]['url']    = '/dashboard';
        $breadcrumb[0]['label']  = 'Dashboard';
        $breadcrumb[0]['active'] = false;
        
        $breadcrumb[1]['url']    = '#';
        $breadcrumb[1]['label']  = 'Grupo de Acesso';
        $breadcrumb[1]['active'] = true;

        $this->parameters->breadcrumb = $breadcrumb;
    }
    
    /**
     * Método responsável por renderizar a index do crud
     * @method index
     * @return html/twig
     */
    public function index(){ 
        $addsParameters = [];
        $addsParameters['listagem'] = GrupoAcesso::getListagem();

        return $this->indexAdminDefault($this->parameters, $addsParameters);
    }
    
    /**
     * Método responsável por renderizar o formulario com ou sem registros
     * @method form
     * @param integer $codGrupoAcesso
     * @return html/twig
     */
    public function form($codGrupoAcesso = null){ 
        $addsParameters = [];
        $addsParameters['menus']  = Menu::getListagem([['status', '=', 'a']]);
        $addsParameters['dados']  = !is_numeric($codGrupoAcesso) ? new GrupoAcesso : GrupoAcesso::find($codGrupoAcesso);
        $this->parameters->view   = $this->folder.'/form';

        if($addsParameters['dados']->status == ''){
            $addsParameters['dados']->status = 'a';
        }

        if($addsParameters['dados'] instanceof GrupoAcesso){
            $addsParameters['id']        = $addsParameters['dados']->idgroup;
            $addsParameters['descricao'] = $addsParameters['dados']->description;

            $addsParameters['label']  = !is_numeric($codGrupoAcesso) ? 'Cadastrar' : 'Editar';

            $obGrupoAcesso = $addsParameters['dados'];
            foreach($addsParameters['menus'] as $menu){
                $menu->checked =  $menu->checkAccessForId($obGrupoAcesso->idgroup) ? 'checked' : '';
            }
        }
        
        return $this->indexAdminDefault($this->parameters, $addsParameters);
    }
}
