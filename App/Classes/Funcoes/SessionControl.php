<?php

namespace App\Classes\Funcoes;

/**
 * Classe responsável por controle de sessão
 * @class SessionControl 
 * @author Oseas Moreto
 */

class SessionControl {

    /**
     * Método responsável por startar a sessão
     * @method start_session
     * @return void
     */
    public static function start_session(){
        if(empty(session_id())) session_start();
    }

    /**
     * Método responsável por apagar a sessão
     * @method session_destroy
     * @return void
     */
    public static function session_destroy(){
        if(empty(session_id())) session_destroy();
    }

    /**
     * Método responsável retornar o session_id
     * @method get_sessao
     * @return string
     */
    public static function get_sessao(){
        self::start_session();
        return session_id();
    }

    /**
     * Método responsável por retornar um valor na sessão
     * @method static getSession
     * @param  string $indice
     * @return mixed
     */
    public static function getSession($indice){
        self::get_sessao();
        return isset($_SESSION[$indice]) ? $_SESSION[$indice] : false;
    }

    /**
     * Método responsável por setar um valor na sessão
     * @method static setSession
     * @param  string $indice
     * @param  string $value
     * @return void
     */
    public static function setSession($indice, $value){
        self::get_sessao();
        $_SESSION[$indice] = $value;
    }
}
