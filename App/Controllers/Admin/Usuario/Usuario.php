<?php

namespace App\Controllers\Admin\Usuario;

use App\Classes\Funcoes\RequestParams;
use App\Templates\Admin\Usuario\TemplateUsuario;
use \App\Classes\Funcoes\SessionControl;
use \App\Controllers\Admin\Common;
use App\Models\Usuario\AccessUser;
use App\Services\Usuario\ServiceUsuario;

/**
 * Classe responsável por gerenciar a página da usuario
 *
 * @author oseas
 */
class Usuario extends Common{

    /**
     * Atributo de link da página
     */
    protected $pagelink = PREFIX_DASHBOARD.'/users';

    /**
     * Método responsável por chamar o template da index da usuario
     * @method index
     * @return html/twig
     */
    public function index(){
        SessionControl::start_session();
        return (new TemplateUsuario)->index();
    }

    /**
     * Método responsável por chamar o template do form 
     * @method form
     * @param int $id
     * @return html/twig
     */
    public function form($id = ''){
        return (new TemplateUsuario)->form($id);
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

        $retornoService = (new ServiceUsuario)->save($request);

        $mensagem = $retornoService['message'];
        $return   = $retornoService['success'] ? $this->getRetornoSucesso($mensagem) : $this->getRetornoErro($mensagem);
        
        $return['id']    = $retornoService['data'] instanceof AccessUser ? $retornoService['data']->iduser : 0;
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

        $retornoService = (new ServiceUsuario)->destroy($id);
        $return = $retornoService['success'] ? $this->getRetornoSucesso('Registro deletado com sucesso.') : $this->getRetornoErro('Erro ao apagar o registro');
        
        print_r(json_encode($return));
        exit();
    }
}
