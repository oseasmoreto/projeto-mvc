<?php
namespace App\Templates\Admin\Usuario;

use App\Classes\Funcoes\SessionControl;
use App\Templates\Admin\Modulos\TemplateLoad;
use App\Models\Usuario\AccessGroup as GrupoAcesso;
use App\Models\Usuario\AccessUser as Usuario;
use stdClass;

/**
 * Classe responsável por gerenciar os templates da Usuario
 * @class TemplateHome
 * @author Oseas Moreto
 */

class TemplateUsuario extends TemplateLoad{

    public $parameters = null;
    private $folder = 'admin/usuario/user';

    public function __construct(){
        //HERDA O CONSTRUCT PAI
        parent::__construct();

        $this->parameters            = new stdClass;
        $this->parameters->view      = $this->folder.'/list';
        $this->parameters->title     = 'Usuarios do Admin';
        $this->parameters->routePage = PREFIX_DASHBOARD.'/users';
        $this->parameters->list      = [];

        $breadcrumb = [];
        
        $breadcrumb[0]['url']    = '/dashboard';
        $breadcrumb[0]['label']  = 'Dashboard';
        $breadcrumb[0]['active'] = false;
        
        $breadcrumb[1]['url']    = '#';
        $breadcrumb[1]['label']  = 'Usuarios do Admin';
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
        $addsParameters['listagem'] = Usuario::getListagem();

        return $this->indexAdminDefault($this->parameters, $addsParameters);
    }
    
    /**
     * Método responsável por renderizar o formulario com ou sem registros
     * @method form
     * @param integer $iduser
     * @return html/twig
     */
    public function form($iduser = null){ 
        $addsParameters = [];
        $addsParameters['grupos'] = GrupoAcesso::getGrupoAcessoPorFiltro(['status', '=', 'a']);
        $addsParameters['dados']  = !is_numeric($iduser) ? new Usuario : Usuario::find($iduser);
        $this->parameters->view   = $this->folder.'/form';

        if($addsParameters['dados']->status == ''){
            $addsParameters['dados']->status = 'a';
        }

        if($addsParameters['dados'] instanceof Usuario){
            $addsParameters['id']        = $addsParameters['dados']->iduser;
            $addsParameters['descricao'] = $addsParameters['dados']->name;
            
            $addsParameters['label']  = !is_numeric($iduser) ? 'Cadastrar' : 'Editar';
        }

        return $this->indexAdminDefault($this->parameters, $addsParameters);
    }
}
