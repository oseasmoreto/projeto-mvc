<?php

namespace App\Core;

use \App\Core\Routes;

/**
* Classe responsável por startar a aplicação
* @author Oseas Moreto
*/

class App {
  
  /**
  * Método responsável por iniciar aplicação
  * @method init
  * @return void
  */
  public static function init(){
    try {
      Routes::init();
    } catch (\Exception $e) {
      header('Location: /error.html');
      exit;
    }
  }
}
