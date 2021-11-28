<?php

namespace App\Classes\Funcoes;

/**
 * Classe responsável por tratar os parametros request (GET,POST,PUT,DELETE)
 * @author Oseas Moreto
*/

class RequestParams{

    /**
     * Método responsável por retornar os dados POST e PUT tratados
     * @method static getPostPutData
     * @param array $request
     * @return array
     */
    public static function getPostPutData($request){
        return self::antiInjection($request);
    }

    /**
     * Método responsável por remover SQLs Injection
     * @method antiInjection
     * @param mixed  $var
     * @param string $q 
     */
    public static function antiInjection($var, $q = '')
    {
        //Verifica se o parâmetro é um array
        if (!is_array($var)) {
            //identifico o tipo da variável e trato a string
            switch (gettype($var)) {
                case 'double':
                case 'integer':
                    if ($var == null) {
                        $var = 0;
                    }
                    $return = $var;
                    break;
                case 'string':
                    /*Verifico quantas vírgulas tem na string.
                    Se for mais de uma trato como string normal,
                    caso contrário trato como String Numérica*/
                    $temp = (substr_count($var, ',') == 1) ? str_replace(',', '*;*', $var) : $var;
                    //aqui eu verifico se existe valor para não adicionar aspas desnecessariamente
                    if (!empty($temp)) {
                        if (is_numeric(str_replace('*;*', '.', $temp))) {
                            $temp = str_replace('*;*', '.', $temp);
                            $return = strstr($temp, '.') ? floatval($temp) : intval($temp);
                        } else {
                            //aqui eu verifico o parametro q para o caso de ser necessário utilizar LIKE com %
                            $return = (empty($q)) ? '\'' . addslashes(str_replace('*;*', ',', $temp)) . '\'' : '\'%' . addslashes(str_replace('*;*', ',', $temp)) . '%\'';
                        }
                    } else {
                        // $return = $temp;
                        return '';
                    }
                    break;
                case '':
                    return '';
                case empty($temp):
                    return '';
                case null:
                    return '';
                default:
                    /*Abaixo eu coloquei uma msg de erro para poder tratar
                    antes de realizar a query caso seja enviado um valor
                    que nao condiz com nenhum dos tipos tratatos desta
                    função. Porém você pode usar o retorno como preferir*/
                    $return = '\'\'';
            }
            //Retorna o valor tipado
            return str_replace("'","",$return);
        } else {
            //Retorna os valores tipados de um array
            return array_map('self::antiInjection', $var);
        }
    }


    
}
