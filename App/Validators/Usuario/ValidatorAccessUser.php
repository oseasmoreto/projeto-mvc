<?php
namespace App\Validators\Usuario;
use App\Models\Usuario\AccessUser;

/**
 * Classe responsável por realizar as rotinas de validação
 * @class ValidatorAccessUser
 * @author Oseas Moreto
 */


class ValidatorAccessUser{

    /**
     * Método responsável por validar o usuário
     * @method validade
     * @param  array $data
     * @return array
     */
    public static function validate($data){
        $return['success'] = true;

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $return['success'] = false;
            $return['message'] = "E-mail inválido!";
            $return['data'] = $data;

            return $return;
        }

        $issetEmail = AccessUser::verificarEmailUsuario($data['email']);

        if(!is_numeric($data['iduser']) && $issetEmail){
            $return['success'] = false;
            $return['message'] = "E-mail já cadastrado em nossa base!";
            $return['data'] = $data;

            return $return;
        }

        $issetUser = AccessUser::verificarEmailUsuario($data['user']);
        if(!is_numeric($data['iduser']) && $issetUser){
            $return['success'] = false;
            $return['message'] = "Usuário já cadastrado em nossa base!";
            $return['data'] = $data;

            return $return;
        }

        if(strlen($data['password']) and $data['password'] <> $data['confirmpassword']){
            $return['success'] = false;
            $return['message'] = "As senhas devem ser iguais!";
            $return['data'] = $data;

            return $return;
        }

        return $return;

    }
}
