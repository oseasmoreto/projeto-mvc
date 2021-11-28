<?php

namespace App\Controllers\Admin\Error;

use App\Templates\Admin\TemplateError;
use \App\Classes\Funcoes\SessionControl;

/**
 * Classe responsável por gerenciar as páginas de Erro
 *
 * @author Oséas Moreto
 */
class Error{
    public function __invoke($request, $response, $exception) {
        return $response
            ->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write(self::error500());
   }
   
   /**
    * Método responsável por renderizar a página de erro 500
    * @method static error500
    * @return hmtl/twig
    */
   public static function error500(){
    return (new TemplateError)->error500();
   }

}
