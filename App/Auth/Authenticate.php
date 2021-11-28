<?php

namespace App\Auth;

use App\Classes\Funcoes\SessionControl;
use App\Models\Usuario\AccessMenu as Menu;
use App\Models\Usuario\AccessUser as Usuario;

/**
 * Classe responsável por autenticar os acesso ao admin
 * @author Oseas Moreto
*/

class Authenticate {

    /**
     * Método responsável por autenticar o login do usuário
     * @method static autenticar
     * @param  array $dadosAcesso
     * @return array
     */
    public static function autenticar($dadosAcesso = []){
        SessionControl::start_session();
        
        $senha = md5($dadosAcesso['password']);
        $obUsuario = Usuario::getUsuario($dadosAcesso['username'], $senha);

        if(!$obUsuario instanceof Usuario) return [
            'mensagem' => 'Usuário ou senha incorreto.',
            'success'  => false
        ];
        
        /** SETA OS DADOS DO USUÁRIO NA SESSÃO */
        $_SESSION['user']        = $obUsuario->user;
        $_SESSION['password']    = $obUsuario->password;
        $_SESSION['idgroup']     = $obUsuario->idgroup;
        $_SESSION['user_id']     = $obUsuario->iduser;
        $_SESSION['name']        = $obUsuario->name;

        return [
            'mensagem' => 'Login realizado com sucesso.',
            'success'  => true
        ];
    }

    /**
     * Método responsável por validar o usuário na sessão
     * @method static logado
     * @param  string $route
     * @return boolean
     */
    public static function logado($route){
        SessionControl::start_session();

        $data['username'] = SessionControl::getSession('user');
        $data['password'] = SessionControl::getSession('password');

        if(!$data['username'] or !$data['password']) return false;

        $obUsuario = Usuario::getUsuario($data['username'], $data['password']);

        if(!$obUsuario instanceof Usuario) return false;

        //PÁGINAS DE EXCEÇÕES
        $excecoes = in_array($route, EXCECOES_PAGES);

        if($excecoes) return true;

        $retorno = Menu::verificarVinculoComGrupo($route, $obUsuario->idgroup);
        
        return $retorno;
    }
    
    /**
     * Método responsável por deslogar da aplicação
     * @method logout
     * @return void
     */
    public static function logout(){
        SessionControl::start_session();
        SessionControl::session_destroy();
    }
}
