<?php

namespace App\Core\OmExecute;

use App\Core\OmExecute\Api;
use App\Core\OmExecute\Generate\Colors;
use App\Core\OmExecute\Help;
use App\Core\OmExecute\Module;

/**
 * Classe responsável por gerenciar o OM Execute
 * @author Oseas Moreto
 */

class OM {

    /**
     * Método responsável por retornar a introdução ao admin
     * @method readMe
     * @return string
     */
    public static function readMe(){
        return Help::listarComandos();
    }

    /**
     * Método responsável por chamar os comandos
     * @method commandsExec
     * @param string $command
     * @param array $params
     * @return void
     */
    public static function commandsExec($command = '', $params = []){
        switch ($command) {
            case '--criar-modulo':
                (new Module)->criarModulo($params);
                break;
            case '--criar-api':
                (new Api)->criarApi($params);
                break;
            case '--help':
                Help::listarComandos();
                break;
            case 'start':
                self::startServer();
                break;
            
            default:
                die((new Colors)->getColoredString("Comando inválido, use --help para obter ajuda.", "red") . "\n");
        }
    }

    /**
     * Método responsável por executar o comando de start do servidor
     * @method static startServer()
     * @return void
     */
    public static function startServer(){
        echo (new Colors)->getColoredString("Iniciando servidor...", "light_red") . "\n";
        return shell_exec('php -S localhost:3001 -t www');
    }
}