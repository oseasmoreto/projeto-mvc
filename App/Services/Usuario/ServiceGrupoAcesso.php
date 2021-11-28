<?php

namespace App\Services\Usuario;

use App\Models\Usuario\AccessGroup as GrupoAcesso;

/**
 * Classe responsável por tratar os registros para ser salvos
 * @author Oseas Moreto
 */

class ServiceGrupoAcesso{
    /**
     * Método responsável por preparar os registros para serem salvos
     * @method save
     * @param array $request
     * @return array [
     *      'success' => bool,
     *      'message' => string,
     *      'data'    => GrupoAcesso
     * ]
     */
    public function save($request) {
        if(empty($request)) return [
            'success' => false,
            'message' => "Request vazia.",
            'data'    => new GrupoAcesso
        ];

        $obGrupoAcesso  = $this->set($request);
        $success = $obGrupoAcesso->save();

        if($success) $obGrupoAcesso->adicionarVinculoComGrupos($request['menus']);

        if($success) return [
            'success' => true,
            'message' => "Registro salvo com sucesso.",
            'data'    => $obGrupoAcesso
        ];
        
        return [
            'success' => false,
            'message' => "Não foi possivel salvar o registro.",
            'data'    => new GrupoAcesso
        ];
    }

    public function destroy($id){
        $obGrupoAcesso  = GrupoAcesso::find($id);
        $obGrupoAcesso->menus()->detach();
        $success = $obGrupoAcesso->delete();

        return [
            'success' => $success
        ];
    }

    public function set($request){
        $obGrupoAcesso = new GrupoAcesso;
        if(isset($request['idgroup']) and is_numeric($request['idgroup'])){
            $obGrupoAcesso = GrupoAcesso::find($request['idgroup']);
        }
        
        $obGrupoAcesso->description = $request['description'];
        $obGrupoAcesso->status      = $request['status'];

        return $obGrupoAcesso;
    }

}
