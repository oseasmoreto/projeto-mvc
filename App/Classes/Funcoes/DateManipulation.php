<?php

namespace App\Classes\Funcoes;

/**
 * Classe responsável por manipulação de datas
 * @class DateManipulation
 * @author Oseas Moreto
 */

class DateManipulation{

    /**
     * Método responsável por retornar o label do mês e dia
     * @method static  daymonthlabel
     * @param  string  $t Indice da posição (m, d)
     * @param  integer $i Indice da posição (mes, dia)
     * @return string
     */
    public static function daymonthlabel($t, $i){
      $array = [];
      $array['m'] = array(
          1 => 'Janeiro',
          'Fevereiro',
          'Março',
          'Abril',
          'Maio',
          'Junho',
          'Julho',
          'Agosto',
          'Setembro',
          'Outubro',
          'Novembro',
          'Dezembro'
      );
      $array['d'] = array(
          1 => 'Domingo',
          'Segunda-Feira',
          'Terça-Feira',
          'Quarta-Feira',
          'Quinta-Feira',
          'Sexta-Feira',
          'Sábado'
      );

      return $array[$t][$i];
    }

    /**
     * Método responsável por retornar o label do mês
     * @method static  returnmonth
     * @param  integer $m Indice do mês
     * @return string
     */
    public static function returnmonth($m){
        $array = array(
          1 => 'Janeiro',
          'Fevereiro',
          'Março',
          'Abril',
          'Maio',
          'Junho',
          'Julho',
          'Agosto',
          'Setembro',
          'Outubro',
          'Novembro',
          'Dezembro'
        );

        return $array[$m];

    }

    /**
     * Método responsável por retornar a diferença em horas entre duas datas
     * @method static dateinterval 
     * @param  string $start
     * @param  string $end
     * @return string 
     */
    public static function dateinterval($start, $end){
      $datatime1 = new \DateTime($start);
      $datatime2 = new \DateTime($end);

      $data1  = $datatime1->format('Y-m-d H:i:s');
      $data2  = $datatime2->format('Y-m-d H:i:s');

      $diff = $datatime1->diff($datatime2);
      $horas = $diff->h + ($diff->days * 24);

      return $horas;

    }

    /**
     * Método reponsável por retornar o label do dia abreviado
     * @method static  searchDay
     * @param  integer $d
     * @return string
     */
    public static function searchDay($d){
      $phrase  = $d;
      $healthy = [1, 2, 3, 4, 5, 6, 7, 8];
      $yummy   = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Fer'];

      $newPhrase = str_replace($healthy, $yummy, $phrase);

      return $newPhrase;
    }

    /**
     * Método responsável por retornar dia e hora atual
     * @method static getTotay
     * @return string
     */
    public static function getToday(){
      return date('Y-m-d H:i:s');
    }

    /**
     * Método responsável por retornar a idade
     * @method static idade
     * @param  string $date
     * @return int
     */
    public static function idade($date){
      // Separa em dia, mês e ano
      list($ano, $mes, $dia) = explode('-', $date);

      // Descobre que dia é hoje e retorna a unix timestamp
      $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
      // Descobre a unix timestamp da data de nascimento do fulano
      $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);

      // Depois apenas fazemos o cálculo já citado :)
      $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);

      return $idade;
    }

    /**
     * Método responsável por retornar a data de 18 anos atrás
     * @method static yearold18
     * @return string
     */
    public static function yearold18(){
        $atual = date('d-m-Y');
        return date('Y-m-d', strtotime('-6570 days', strtotime($atual)));
    }

}
