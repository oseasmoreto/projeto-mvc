<?php

namespace App\Core\OmExecute\Generate;

/**
 * Classe responsável pelo gerenciamento de criação de arquivos
 * @author Oseas Moreto
 */

class File {
    /**
     * Diretório do admin
     * @var string
     */
    private $dir = null;

    /**
     * Array de paths dos packages
     * @var array
     */
    private $paths = [];

    /**
     * Diretório dos arquivos
     * @var string
     */
    public $package = '';

    /**
     * Pasta de views
     * @var string
     */
    public $viewPath = '';

    /**
     * Seta os atributos principais da classe
     * @method __construct
     * @return void
     */
    function __construct() {
        $this->dir = __DIR__.'\..\..\..\\';
    }

    /**
     * Método responsável por setar os paths
     * @method setPath()
     * @return void
     */
    public function setPath(){
        $diretorio    = explode('\\', $this->package);
        $newDiretorio = [];

        foreach ($diretorio as $key => $value) {
            $newDiretorio[] = lcfirst($value);
        }

        $dir = implode('\\', $newDiretorio);

        $this->paths = [
            'controller' => $this->dir.'controllers\\'.$dir,
            'model'      => $this->dir.'models\\'.$dir,
            'route'      => $this->dir.'routes\\'.$dir,
            'service'    => $this->dir.'services\\'.$dir,
            'template'   => $this->dir.'templates\\'.$dir,
            'view'       => $this->dir.'views\\'.$dir.'\\'.strtolower($this->viewPath)
        ];
    }

    /**
     * Método responsável por verificar se o diretório existe
     * @method isDir
     * @param string $path
     * @return boolean
     */
    public function isDir($path){
        return is_dir($path);
    }
    
    /**
     * Método responsável por criar os arquivos
     * @method createFile
     * @param string $file
     * @param string $path
     * @param string $default
     * @param array $variables
     * @return bool
     */
    public function createFile($file, $path, $default = 'blank-class.default', $variables = []){
        //VERIFICA SE O DIRETORIO EXISTE, SE NAO ELE CRIA
        if(!$this->isDir($this->paths[$path])) mkdir($this->paths[$path], 0777, true);
        
        $newFile = fopen($this->paths[$path]."\\".$file, "w") or die((new Colors)->getColoredString("Não foi possivel criar o arquivo: ".$file, "red"));
        $content = file_get_contents(__DIR__.'\..\\.default\\'.$default);

        $content = $this->replaceVariables($content,$variables);
        fwrite($newFile, $content);
        fclose($newFile);

        return true;
    }

    /**
     * Método responsável por inserir as variáveis no template da classe
     * @method mixed replaceVariables()
     * @param string $content
     * @param array $variables
     * @return string
     */
    public function replaceVariables($content = '', $variables = []){
        $newVariables = [];

        foreach ($variables as $key => $value) {
            $newVariables['{{'.$key.'}}'] = $value;
        }

        return strtr($content, $newVariables);
    }
}