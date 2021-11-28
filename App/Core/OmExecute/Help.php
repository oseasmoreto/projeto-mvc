<?php

namespace App\Core\OmExecute;

use App\Core\OmExecute\Generate\Colors;

/**
 * Classe responsável por gerenciar as ações de ajuda
 * @author Oseas Moreto
 */

class Help {

    /**
     * Método responsável por listar comandos
     * @method listarComandos
     * @return void
     */
    public static function listarComandos(){
        print_r("************************************************************************************\n");
        print_r((new Colors)->getColoredString("
         ,-.  .   ,                       .      
        /   \ |\ /|                       |      
        |   | | V |   ,-. . , ,-. ,-. . . |-  ,-.
        \   / |   |   |-'  X  |-' |   | | |   |-'
         `-'  '   '   `-' ' ` `-' `-' `-` `-' `-'\n\n","light_purple"));
        print_r("  Módulos:\n");
        print_r((new Colors)->getColoredString("    --criar-modulo [nomeModulo]","light_purple")." Cria um novo módulo\n");
        print_r("  Ajuda:\n");
        print_r((new Colors)->getColoredString("    --help","light_purple")." Lista os comandos disponiveis no admin\n");
        print_r("  Server:\n");
        print_r((new Colors)->getColoredString("    start","light_purple")." Inicia o servidor da aplicação\n\n");
        print_r("************************************************************************************\n");
    }
}