<?php

namespace App\Controllers\Admin\Error;

use App\Templates\Admin\TemplateError;

/**
 * Classe responsável por gerenciar as páginas de Página não encontrada
 *
 * @author Oséas Moreto
 */
class NotFound{

   /**
    * Método responsável por renderizar a página de erro 404
    * @method static error404
    * @return hmtl/twig
    */
   public static function error404(){
    return (new TemplateError)->error404();
   }

}
