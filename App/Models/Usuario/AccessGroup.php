<?php

namespace App\Models\Usuario;

use App\Core\Model;
use App\Models\Usuario\AccessMenu;
use App\Models\Usuario\AccessUser;

/**
 * Classe responsável por gerenciar as interações com o banco de dados da tabela access_group
 * @author Oseas Moreto
 */
class AccessGroup extends Model {
    protected $table      = 'access_group';
    protected $primaryKey = 'idgroup';
    public $timestamps    = false;
    protected $guarded    = [];

    /**
     * Método responsável por retornar os menus vinculados ao grupo
     * @method menus
     * @return mixed
     */
    public function menus(){
        return $this->belongsToMany(AccessMenu::class, 'access_menuxgroup', $this->primaryKey, 'idmenu');
    }

    /**
     * Método responsável por retornar os usuários vinculados ao grupo
     * @method users
     * @return mixed
     */
    public function users(){
        return $this->hasMany(AccessUser::class, $this->primaryKey);
    }

    /**
     * Método responsável por retornar todos os grupos com filtragem
     * @method static getGrupoAcessoPorFiltro
     * @param  array $filtro [condicao1, condicao2]
     * @return [AccessGroup]
     */
    public static function getGrupoAcessoPorFiltro($where = []){
        return self::getListagem([$where]);
    }

    /**
     * Método responsável por retornar a listagem dos grupo_acessos
     * @method static getListagem
     * @param array $request
     * @return array
     */
    public static function getListagem($request = []){

        $obAccessGroup = new self;

        if(!empty($request)){
            foreach($request as $key => $data){
                $obAccessGroup->where($data[0], $data[1], $data[2]);
            }
        }

        return $obAccessGroup->get();
    }

    /**
     * Método responsável por vincular o menu aos grupos
     * @method adicionarVinculoComGrupos
     * @param array $menus
     * @return mixed
     */
    public function adicionarVinculoComGrupos($menus){
        if(!is_array($menus) or count($menus) == 0) return false;

        return $this->menus()->sync($menus);
    }


}
