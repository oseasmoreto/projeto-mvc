<?php

namespace App\Controllers\Api;

use \App\Classes\Funcoes\SessionControl;

use \App\Core\Controller;

/**
 * Classe responsável por gerenciar métodos comuns entre as APIs
 * @author Oseas Moreto
 */
class Common extends Controller{
    public function __construct(){}

    /**
     * Método responsável por tratar o retorno da API
     *
     * @param boolean $success
     * @param integer $httpCode
     * @param array $body
     * @return array
     */
    public function returnApi($success = false, $httpCode = 404, $body = []){
        return [
            'success' => $success,
            'code'    => $httpCode,
            'body'    => $body
        ];
    }

    /**
     * Método responsável por validar os filtros de listagem
     * @method filterValidate
     * @param array $filters
     * @return mixed
     */
    public function filterValidate($filters = []){
        if(empty($filters)) return [];

        $filtrosValidos = ['title','limit','offset','id','hash', 'orderBy', 'page', 'category', 'service'];

        foreach ($filters as $key => $filter) {
            if(!in_array($key, $filtrosValidos)) 
                return $this->returnApi(false, 404, ['message' => "Filtro inválido: ".$key]);
        }

        return [];
    }
}
