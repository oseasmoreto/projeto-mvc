<?php

namespace App\Controllers\Api;

use \App\Classes\Funcoes\SessionControl;
use \App\Controllers\Api\Common;

/**
 * Classe responsável pelo controle das informações da API Home
 * @author Oseas Moreto
 */

class Home extends Common{

    protected $pagelink = 'api';

    public function __construct(){}

}
