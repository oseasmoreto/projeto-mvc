<?php

namespace App\Services\Usuario;

use App\Models\Usuario\AccessUser as Usuario;
use App\Validators\Usuario\ValidatorAccessUser;

/**
 * Classe responsável por tratar os registros para ser salvos
 * @author Oseas Moreto
 */

class ServiceUsuario{
    /**
     * Método responsável por preparar os registros para serem salvos
     * @method save
     * @param array $request
     * @return array [
     *      'success' => bool,
     *      'message' => string,
     *      'data'    => Usuario
     * ]
     */
    public function save($request) {
        if(empty($request)) return [
            'success' => false,
            'message' => "Request vazia.",
            'data'    => new Usuario
        ];

        $validate = ValidatorAccessUser::validate($request);

        if(!$validate['success']) return [
            'success' => false,
            'message' => $validate['message'],
            'data'    => $validate['data']
        ];

        $obUsuario  = $this->set($request);
        $success = $obUsuario->save();

        if($success) return [
            'success' => true,
            'message' => "Registro salvo com sucesso.",
            'data'    => $obUsuario
        ];
        
        return [
            'success' => false,
            'message' => "Não foi possivel salvar o registro.",
            'data'    => new Usuario
        ];
    }

    public function destroy($id){
        $obUsuario  = Usuario::find($id);
        $success    = $obUsuario->delete();

        return [
            'success' => $success
        ];
    }

    public function set($request){
        $obUsuario = new Usuario;
        if(isset($request['iduser']) and is_numeric($request['iduser'])){
            $obUsuario = Usuario::find($request['iduser']);
        }

        if(!is_numeric($request['iduser'])){
            $obUsuario->password = md5($request['password']);
        }
        
        $obUsuario->name    = $request['name'];
        $obUsuario->email   = $request['email'];
        $obUsuario->phone   = $request['phone'];
        $obUsuario->status  = $request['status'];
        $obUsuario->user    = $request['user'];
        $obUsuario->idgroup = $request['idgroup'];
        
        if(isset($request['image']) and strlen($request['image'])) $obUsuario->image   = $request['image'];

        return $obUsuario;
    }

}
