<?php

namespace App\Core;

use stdClass;
use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;

/**
 * Classe responsável por configuração e manipulação dos templates
 * @class Template
 * @author Oséas Moreto
 */
class Template{

    /**
     * Objeto Twig
    */
    protected $template = null;

    /**
     * Método responsável por setar as configs do template
     * @method setConfigs
     * @param array $configs
     * @return void
     */
    protected function setConfigs($configs = ['folder' => '../App/views']){
        $loader         = new FilesystemLoader($configs['folder']);
        $this->template = new Environment($loader);
    }

    /**
     * Método responsável por renderizar as páginas
     * @method render
     * @param string $view
     * @param array  $params
     * @return html/twig
     */
    protected function render($view, $params = []){
        //ADICIONA AS CONSTANTES DO SISTEMA
        $this->getVariablesSystem();
        return $this->template->render($view.'.twig', $params);
    }

    /**
     * Método responsável por adicionar variaveis de sessão e constantes ao render
     * @method getVariablesSystem
     * @param array $params
     * @return void
     */
    private function getVariablesSystem(){
        $this->template->addGlobal('URL_DEFAULT_TEMPLATE_SISTEMA', URL_DEFAULT_TEMPLATE_SISTEMA);
        $this->template->addGlobal('TITULO_SISTEMA', TITULO_SISTEMA);
        $this->template->addGlobal('LOGO_SISTEMA', LOGO_SISTEMA);
        $this->template->addGlobal('URL_DEFAULT_SITE', URL_DEFAULT_SITE);
        $this->template->addGlobal('CHAVE_ONESIGNAL', CHAVE_ONESIGNAL);
        $this->template->addGlobal('API_REST_ONESIGNAL', API_REST_ONESIGNAL);
        $this->template->addGlobal('PREFIX_DASHBOARD', PREFIX_DASHBOARD);
    }
}
