<?php
namespace App\Templates\Admin\Usuario;

use App\Classes\Funcoes\SessionControl;
use App\Templates\Admin\Modulos\TemplateLoad;
use App\Models\Usuario\AccessGroup as GrupoAcesso;
use App\Models\Usuario\AccessMenu as Menu;
use stdClass;

/**
 * Classe responsável por gerenciar os templates da Menu
 * @class TemplateHome
 * @author Oseas Moreto
 */

class TemplateMenu extends TemplateLoad{

    public $parameters = null;
    private $folder    = 'admin/usuario/menu';

    public function __construct(){
        //HERDA O CONSTRUCT PAI
        parent::__construct();

        $this->parameters           = new stdClass;
        $this->parameters->adds     = new stdClass;
        $this->parameters->view     = $this->folder.'/list';
        $this->parameters->title    = 'Menus do Admin';
        $this->parameters->routePage = PREFIX_DASHBOARD.'/menus';
        $this->parameters->list     = [];

        $breadcrumb = [];
        
        $breadcrumb[0]['url']    = '/dashboard';
        $breadcrumb[0]['label']  = 'Dashboard';
        $breadcrumb[0]['active'] = false;
        
        $breadcrumb[1]['url']    = '#';
        $breadcrumb[1]['label']  = 'Menus do Admin';
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
        $addsParameters['listagem'] = Menu::getListagem();

        return $this->indexAdminDefault($this->parameters, $addsParameters);
    }
    
    /**
     * Método responsável por renderizar o formulario com ou sem registros
     * @method form
     * @param integer $idmenu
     * @return html/twig
     */
    public function form($idmenu = null){ 
        $addsParameters = [];
        $addsParameters['grupos'] = GrupoAcesso::getGrupoAcessoPorFiltro(['status', '=', 'a']);
        $addsParameters['niveis'] = Menu::getMenuNivelPrincipal(SessionControl::getSession('idgroup'));
        $addsParameters['dados']  = !is_numeric($idmenu) ? new Menu : Menu::find($idmenu);
        $this->parameters->view   = $this->folder.'/form';

        if($addsParameters['dados']->status == ''){
            $addsParameters['dados']->status = 'a';
        }

        if($addsParameters['dados'] instanceof Menu){
            $addsParameters['id']        = $addsParameters['dados']->idmenu;
            $addsParameters['descricao'] = $addsParameters['dados']->page;
            
            $addsParameters['label']  = !is_numeric($idmenu) ? 'Cadastrar' : 'Editar';

            $obMenu = $addsParameters['dados'];
            foreach($addsParameters['grupos'] as $grupo){
                $grupo->checked =  $obMenu->checkAccessForId($grupo->idgroup) ? 'checked' : '';
            }
        }

        return $this->indexAdminDefault($this->parameters, $addsParameters);
    }
}
