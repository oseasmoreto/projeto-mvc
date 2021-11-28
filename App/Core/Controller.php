<?php

namespace App\Core;

use App\Classes\Funcoes\Generate;
use App\Classes\Funcoes\SessionControl;
use App\Core\Action;

/**
 * Description of Controller
 *
 * @author oseas
 */
class Controller{

    public function upload($file, $path){
        ini_set('upload_max_filesize', '20M');

        // A list of permitted file extensions
        $allowed = array('png', 'jpg', 'gif', 'jpeg', 'pdf', 'doc', 'zip', 'rar', 'xlsx', 'csv', 'svg');

        SessionControl::start_session();
        $response = [];
        $new_name = '';
        

        if (isset($file['file']) && $file['file']['error'] == 0) {
            $caminho = $_SERVER['DOCUMENT_ROOT'] . '/images/' . $path;
            $c = 'images';

            $extension = pathinfo($file['file']['name'], PATHINFO_EXTENSION);
            //echo $extension;

            if (!in_array(strtolower($extension), $allowed)) {
                $response['success'] = false;
                $response['status']  = '0';
                $response['message'] = 'As extensões permitidas são: ' . implode(',', $allowed);
            }

            if ($extension == 'pdf' || $extension == 'doc' || $extension == 'vcf' || $extension == 'zip' || $extension == 'rar' || $extension == 'xlsx' || $extension == 'csv') {
                $caminho = str_replace('images', 'files', $caminho);
                $c = str_replace('images', 'files', $c);
            }

            if (!is_dir($caminho)) {
                mkdir($caminho, 0777);
            }

            $new_name = Generate::url_generate($file['file']['name']). date('YmdHis') . '.' . $extension;

            if (move_uploaded_file($file['file']['tmp_name'], $caminho . '/' . $new_name)) {
                $response['success'] = true;
                $response['status']  = '1';
                $response['message'] = 'Upload feito com sucesso!';
                $response['image'] = '/' . $c . '/' . $path . '/' . $new_name;
            } else {
                $response['success'] = false;
                $response['status']  = '0';
                $response['message'] = 'Ocorreu algum erro ao subir a imagem!';
            }
        } else {
            $response['success'] = false;
                $response['status']  = '0';
            $response['message'] = 'Erro ao subir a imagem: ' . $file['file']['error'];
        }

        return $response;
    }
}
