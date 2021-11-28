<?php

namespace App\Core\OmExecute\Generate;

/**
 * Classe responsável por gerenciar as ações em models
 * @author Oseas Moreto
 */

class Model {

    /**
     * Model
     * @var string model
     */
    public $model = null;

    /**
     * Package
     * @var string package
     */
    public $package = null;

    /**
     * Tabela
     * @var string tabela
     */
    public $tabela = '';

    /**
     * Pk
     * @var string pk
     */
    public $pk = '';

    /**
     * Model Pai
     * @var string modelPai
     */
    public $modelPai = '';

    /**
     * Método responsável por criar o model
     * @method createModel
     * @return bool
     */
    public function createModel(){
       
        $variables = [
            'package' => $this->package,
            'model'   => $this->model
        ];

        if(strlen($this->tabela)) $variables['table'] = $this->tabela;
        if(strlen($this->pk)) $variables['pk'] = $this->pk;

        //INSTANCIA O OBJETO FILE
        $obFile = new File;
        $obFile->package  = $this->package;
        $obFile->setPath();

        $obFile->createFile($this->model.'.php', 'model', 'model.default',$variables);

        return true;
    }

    /**
     * Método responsável por criar o model
     * @method createModelApi
     * @return bool
     */
    public function createModelApi(){

        $modelName = str_replace('\\', '', $this->modelPai);
       
        $variables = [
            'package'     => $this->package,
            'model'       => $this->model,
            'modelPai'    => $modelName,
            'useModelPai' => 'use \\'.$this->modelPai.' as '.$modelName
        ];

        //INSTANCIA O OBJETO FILE
        $obFile = new File;
        $obFile->package  = $this->package;
        $obFile->setPath();

        $obFile->createFile($this->model.'.php', 'model', 'api\\model.default',$variables);

        return true;
    }

    /**
     * Método responsável por setar os dados de model
     * @method static setDadosModel()
     * @param array $dadosCadastro
     * @return void
     */
    public static function setDadosModel(&$dadosCadastro){
        $dadosCadastro['criarEntidade'] = (string)readline("Deseja criar um model? (s/n) ");
        switch ($dadosCadastro['criarEntidade']) {
            case 's':
                $dadosCadastro['model'] = (string)readline("Insira o nome do Model: ");
                $dadosCadastro['table'] = (string)readline("Insira o nome da tabela: ");
                $dadosCadastro['pk']    = (string)readline("Insira o nome da primary key: ");
                break;
            default:
                $dadosCadastro['model'] = (string)readline("Insira o Model que será utilizado no módulo: ");
                break;
        }
    }

    /**
     * Método responsável por setar os dados de model
     * @method static setDadosModelApi()
     * @param array $dadosCadastro
     * @return void
     */
    public static function setDadosModelApi(&$dadosCadastro){
        $dadosCadastro['model']    = (string)readline("Insira o nome do Model: ");
        $dadosCadastro['modelPai'] = (string)readline("Insira o Model pai com namespace: ");
    }
}