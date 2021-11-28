<?php

namespace App\Controllers\Admin;

use App\Auth\Authenticate;
use App\Classes\Funcoes\RequestParams;
use \App\Controllers\Admin\Common;
use \App\Classes\Funcoes\SessionControl;
use App\Templates\Admin\TemplateLogin;

/**
 * Classe responsável por gerenciar as acões de login
 *
 * @author Oseas Moreto
 */
class Login extends Common
{

    protected $titulo_pagina = 'Login';

    /**
     * Método responsável por chamar o template da index do login
     * @return mixed
     */
    public function index(){
        SessionControl::start_session();
        return (new TemplateLogin)->index();
    }

    /**
     * Método responsável por manipular a ação de logar do site
     * @method logar
     * @param  array $request
     * @return array
     */
    public function logar($request){
        $request     = RequestParams::getPostPutData($request);
        $autenticado = Authenticate::autenticar($request);

        $return = [];

        $return['response']['mensagem'] = $autenticado['success'] ? 'Login realizado com sucesso.' : 'Usuário ou senha incorreto.';
        $return['response']['classe']   = $autenticado['success'] ? 'alert-success' : 'alert-danger';
        $return['response']['result']   = $autenticado['success'] ? 'success' : 'error';
        $return['response']['redirect'] = $autenticado['success'] ? PREFIX_DASHBOARD.'/' : '';

        return $return;
    }
    
    /**
     * Método responsável por deslogar da aplicação
     * @method logout
     * @return void
     */
    public function logout(){
        SessionControl::start_session();
        Authenticate::logout();
    }
}
