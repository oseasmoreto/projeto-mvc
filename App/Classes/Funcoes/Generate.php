<?php

namespace App\Classes\Funcoes;

/**
* Classe responsável por geração de hashs, urls, pass
* @class DateManipulation
* @author Oseas Moreto
*/

class Generate{
  
  /**
  * Método responsável por gerar uma string
  * @method static  generate_string
  * @param  integer $strength
  * @return string
  */
  public static function generate_string($strength = 6) {
    $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
      $random_character = $input[mt_rand(0, $input_length - 1)];
      $random_string .= $random_character;
    }
    
    return $random_string;
  }
  
  /**
  * Método responsável por gerar uma url amigável
  * @method static  url_generate
  * @param  integer $string
  * @return string
  */
  public static function url_generate($string){
    $string = trim($string);
    $table = array(
      'Š'=>'S', 'š'=>'s', 'Ð'=>'D', 'd'=>'d', 'Ž'=>'Z',
      'ž'=>'z', 'C'=>'C', 'c'=>'c', 
      'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
      'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
      'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
      'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
      'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
      'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
      'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
      'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
      'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
      'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
      'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
      'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b',
      'ÿ'=>'y', 'R'=>'R', 'r'=>'r',
    );
    // Traduz os caracteres em $string, baseado no vetor $table
    $string = strtr($string, $table);
    // converte para minúsculo
    $string = strtolower($string);
    // remove caracteres indesejáveis (que não estão no padrão)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    // Remove múltiplas ocorrências de hífens ou espaços
    $string = preg_replace("/[\s-]+/", " ", $string);
    // Transforma espaços e underscores em hífens
    $string = preg_replace("/[\s_]/", "-", $string);
    // retorna a string
    return $string;
  }
  
  /**
  * Método responsável por gerar senhas aleatórias
  * @method static passGenerate
  * @param integer $tamanho
  * @param boolean $maiusculas
  * @param boolean $minusculas
  * @param boolean $numeros
  * @param boolean $simbolos
  * @return string
  */
  public static function passGenerate($tamanho, $maiusculas, $minusculas, $numeros, $simbolos){
    $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
    $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
    $nu = "0123456789"; // $nu contem os números
    $si = "!@#$%¨&*()_+="; // $si contem os símbolos
    
    $senha = '';
    if ($maiusculas){
      // se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
      $senha .= str_shuffle($ma);
    }
    
    if ($minusculas){
      // se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
      $senha .= str_shuffle($mi);
    }
    
    if ($numeros){
      // se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
      $senha .= str_shuffle($nu);
    }
    
    if ($simbolos){
      // se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
      $senha .= str_shuffle($si);
    }
    
    // retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
    return substr(str_shuffle($senha),0,$tamanho);
  }
  
  /**
  * Método responsável por gerar hashs
  * @method static gerar_hash
  * @param  string $password
  * @return string
  */
  public static function gerar_hash($password){
    $salt = sha1(rand());
    $salt = substr($salt, 0, 10);
    $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
    
    return $encrypted;
  }
  
  /**
   * Método responsável por retornar a string limitada
   * @param integer $limit
   * @param string $string
   * @param boolean $pontilhado
   * @return string
   */
  public static function limitarTexto($limit, $string, $pontilhado = false){
    $string = strip_tags($string);

    if(strlen($string) <= $limit) return $string.($pontilhado ? '...' : '');

    $limit_text = substr($string, 0, $limit);
    $endPoint   = strrpos($limit_text, ' ');
    $string     = $endPoint? substr($limit_text, 0, $endPoint):substr($limit_text, 0);

    if($pontilhado) $string .= '...';

    return $string;
  }
}
