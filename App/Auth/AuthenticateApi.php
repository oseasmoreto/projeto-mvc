<?php

namespace App\Auth;

use App\Models\Usuario\AccessUser as Usuario;
use App\Core\JWTWrapper;

/**
 * Classe responsável por autenticar os acesso ao admin
 * @author Oseas Moreto
*/

class AuthenticateApi {

    /**
     * Método responsável por autenticar o login do usuário
     * @method static autenticar
     * @param  array $dadosAcesso
     * @return array
     */
    public static function autenticar($dadosAcesso = []){

        if(!isset($dadosAcesso['password']) or !isset($dadosAcesso['username'])) return [
            'mensagem' => 'Parametros inválidos.',
            'success'  => false,
            'body'     => []
        ];
        
        $senha = md5($dadosAcesso['password']);
        $obUsuario = Usuario::getUsuario($dadosAcesso['username'], $senha);

        if(!$obUsuario instanceof Usuario) return [
            'mensagem' => 'Usuário ou senha incorreto.',
            'success'  => false,
            'body'     => []
        ];
        
        $accessToken = JWTWrapper::encode([
            'expiration_sec' => 14400,
            'iss' => URL_SITE,        
            'userdata' => [
                'id'   => $obUsuario->iduser,
                'name' => $obUsuario->name
            ]
        ]);

        return [
            'mensagem' => 'Login realizado com sucesso.',
            'success'  => true,
            'body'     => [
                'accessToken' => $accessToken
            ]
        ];
    }
}
