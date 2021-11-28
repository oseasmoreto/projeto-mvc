<?php

namespace App\Services\Usuario;

use App\Models\Usuario\AccessMenu as Menu;

/**
 * Classe responsável por tratar os registros para ser salvos
 * @author Oseas Moreto
 */

class ServiceMenu{
    /**
     * Método responsável por preparar os registros para serem salvos
     * @method save
     * @param array $request
     * @return array [
     *      'success' => bool,
     *      'message' => string,
     *      'data'    => Menu
     * ]
     */
    public function save($request) {
        if(empty($request)) return [
            'success' => false,
            'message' => "Request vazia.",
            'data'    => new Menu
        ];

        $obMenu  = $this->set($request);
        $success = $obMenu->save();

        if($success) $obMenu->adicionarVinculoComGrupos($request['groups']);

        if($success) return [
            'success' => true,
            'message' => "Registro salvo com sucesso.",
            'data'    => $obMenu
        ];
        
        return [
            'success' => false,
            'message' => "Não foi possivel salvar o registro.",
            'data'    => new Menu
        ];
    }

    public function destroy($id){
        $obMenu  = Menu::find($id);
        $success = $obMenu->delete();

        return [
            'success' => $success
        ];
    }

    public function set($request){
        $obMenu = new Menu;
        if(isset($request['idmenu']) and is_numeric($request['idmenu'])){
            $obMenu = Menu::find($request['idmenu']);
        }
        
        $obMenu->title  = $request['title'];
        $obMenu->page   = $request['page'];
        $obMenu->alias  = $request['alias'];
        $obMenu->level  = $request['level'];
        $obMenu->status = $request['status'];
        $obMenu->icon   = $request['icon'];
        $obMenu->order  = $request['order'];

        return $obMenu;
    }

}
