<?php

namespace App\Controllers\Admin\Usuario;

use App\Classes\Funcoes\RequestParams;
use \App\Classes\Funcoes\SessionControl;
use \App\Controllers\Admin\Common;
use App\Templates\Admin\Usuario\TemplateGrupoAcesso;
use App\Services\Usuario\ServiceGrupoAcesso;

/**
 * Classe responsável por gerenciar a página da grupo de acesso
 *
 * @author oseas
 */
class GrupoAcesso extends Common{

    /**
     * Atributo de link da página
     */
    protected $pagelink = PREFIX_DASHBOARD.'/grupoacesso';

    /**
     * Método responsável por chamar o template da index da grupo de acesso
     * @method index
     */
    public function index(){
        SessionControl::start_session();
        return (new TemplateGrupoAcesso)->index();
    }

    /**
     * Método responsável por chamar o template do form 
     * @method form
     * @param int $id
     */
    public function form($id = ''){
        return (new TemplateGrupoAcesso)->form($id);
    }

    /**
     * Método responsável por salvar os registros
     * @method save
     * @param array $request
     * @return bool
     */
    public function save($request){
        $request = RequestParams::getPostPutData($request);
        $return  = $this->getRetornoErro();

        $retornoService = (new ServiceGrupoAcesso)->save($request);

        $mensagem = $retornoService['message'];
        $return   = $retornoService['success'] ? $this->getRetornoSucesso($mensagem) : $this->getRetornoErro($mensagem);

        $return['id']    = $retornoService['data']->idgroup;
        $return['route'] = $this->pagelink;
        
        print_r(json_encode($return));
        exit();
    }

    /**
     * Método responsável por deletar os registros
     * @method delete
     * @param array $request
     * @return bool
     */
    public function delete($id){
         if(!is_numeric($id)) $this->getRetornoErro();

        $retornoService = (new ServiceGrupoAcesso)->destroy($id);
        $return = $retornoService['success'] ? $this->getRetornoSucesso('Registro deletado com sucesso.') : $this->getRetornoErro('Erro ao apagar o registro');
        
        print_r(json_encode($return));
        exit();
    }
}
