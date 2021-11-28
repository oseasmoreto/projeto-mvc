<?php

namespace App\Controllers\Api;

use App\Auth\AuthenticateApi;
use App\Classes\Funcoes\RequestParams;
use \App\Controllers\Api\Common;

/**
 * Classe responsável por gerenciar as acões de login na API
 *
 * @author Oseas Moreto
 */
class Auth extends Common{

    /**
     * Método responsável por manipular a ação de logar do site
     * @method logar
     * @param  array $request
     * @return array
     */
    public function autenticar($request){
        $request     = RequestParams::getPostPutData($request);
        $autenticado = AuthenticateApi::autenticar($request);

        $return = [];

        $return['success']  = $autenticado['success'];
        $return['message']  = $autenticado['success'] ? 'Acesso autorizado.' : 'Usuário ou senha incorreto.';
        $return['code']     = $autenticado['success'] ? 200 : 401;
        $return['body']     = $autenticado['body'];

        return $return;
    }
}
