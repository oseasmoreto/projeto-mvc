<?php

namespace App\Controllers\Admin;

use \App\Core\Controller;

/**
 * Classe responsável por gerenciar métodos comuns entre os controllers
 * @author Oseas Moreto
 */
class Common extends Controller{

    /**
     * Método responsável por retornar array de erro
     * @method getRetornoErro
     * @param string $mensagem
     * @return array
     */
    public function getRetornoErro($mensagem = ''){
        return [
                'response' => [
                    'mensagem' => strlen($mensagem) ? $mensagem : 'Erro ao executar a ação.',
                    'classe'   => 'alert-danger',
                    'result'   => 'error',
                    'redirect' => '',
                    'reload'   => false
                ]
            ];
    }

    /**
     * Método responsável por retornar array de sucesso
     * @method getRetornoSucesso
     * @param string $mensagem
     * @return array
     */
    public function getRetornoSucesso($mensagem = ''){
        return [
                'response' => [
                    'mensagem' => strlen($mensagem) ? $mensagem : 'Ação executada com sucesso.',
                    'classe'   => 'alert-success',
                    'result'   => 'success',
                    'redirect' => '',
                    'reload'   => true
                ]
            ];
    }
}
