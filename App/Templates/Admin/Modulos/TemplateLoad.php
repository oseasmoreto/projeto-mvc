<?php

namespace App\Templates\Admin\Modulos;

use App\Classes\Funcoes\SessionControl;
use App\Core\Template;
use App\Models\Usuario\AccessMenu as Menu;
use stdClass;
/**
 * Classe responsável por manipular os templates de admin
 * @class TemplateLoad
 * @author Oseas Moreto
 */
class TemplateLoad extends Template{

    public function __construct(){
        $this->setConfigs();
    }

    /**
     * Método responsável por renderizar as páginas defaults do admin
     * @method indexAdminDefault
     * @param stdClass $parameters
     * @param array    $addsParameters
     * @return mixed
     */
    public function indexAdminDefault(stdClass $parameters, array $addsParameters = []){
        $params = [];

        $params['breadcrumb'] = $parameters->breadcrumb;

        $params['url']    = '/' . $parameters->routePage;
        $params['titulo'] = $parameters->title;

        $params['sidebar']   = !isset($parameters->sidebar) ? self::sidebar(): [];
        $params['routePage'] = $parameters->routePage;

        if(SessionControl::getSession('user_id')){
            $params['name']        = SessionControl::getSession('name');
            $params['firstLetter'] = $params['name'][0];
            $params['user_id']     = SessionControl::getSession('user_id');
        }

        if (!empty($addsParameters)) $params = array_merge($params, $addsParameters);
        
        return $this->render($parameters->view, $params);
    }

    /**
     * Método responsável por retornar as variáveis de menu
     * @method sidebar
     * @return array
     */
    public static function sidebar(){
        $codGrupoAcesso = SessionControl::getSession('idgroup');
        $arrayObMenu = Menu::getMenuNivelPrincipal($codGrupoAcesso);
        
        $retornoMenu = [];

        foreach ($arrayObMenu as $key => $obMenu) {
            $retornoMenu[] = self::formatarMenu($obMenu, $codGrupoAcesso, true);
        }

        return $retornoMenu;
    }

    /**
     * Método responsável por formatar os registros dos menus
     * @method static formatarMenu
     * @param  Menu   $obMenu
     * @param  int    $codGrupoAcesso
     * @param  bool   $principal
     * @return array
     */
    public static function formatarMenu($obMenu, $codGrupoAcesso, $principal){
        $arrayMenu = [
            'label'   => $obMenu->title,
            'url'     => PREFIX_DASHBOARD.'/'.$obMenu->page,
            'icone'   => $obMenu->icon,
            'level'   => $obMenu->level,
            'ativo'   => false,
            'submenu' => []
        ];

        if(!$principal) return $arrayMenu;

        $arrayObMenu = Menu::getMenuPorNivel($obMenu->idmenu, $codGrupoAcesso);

        foreach ($arrayObMenu as $key => $obMenu) {
            $arrayMenu['submenu'][] = self::formatarMenu($obMenu, $codGrupoAcesso, false);
        }

        return $arrayMenu;
    }

}
