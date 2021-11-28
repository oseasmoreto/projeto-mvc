<?php

namespace App\Models\Usuario;

use App\Core\Model;
use App\Models\Usuario\AccessGroup;

/**
 * Classe responsável por gerenciar as interações com o banco de dados da tabela access_menu
 * @author Oseas Moreto
 */
class AccessMenu extends Model {
    protected $table      = 'access_menu';
    protected $primaryKey = 'idmenu';
    public $timestamps    = false;
    protected $guarded    = [];

    /**
     * Método responsável por retornar os grupos vinculados
     * @method groups
     */
    public function groups(){
        return $this->belongsToMany(AccessGroup::class, 'access_menuxgroup', $this->primaryKey, 'idgroup');
    }

    /**
     * Método responsável por retornar o vinculo do menu com o grupo de acesso
     * @method static verificarVinculoComGrupo
     * @param  string $rota
     * @param  string $idgroup
     * @return bool
     */
    public static function verificarVinculoComGrupo($rota, $idgroup){
        if(!strlen($rota)) return false;
        if(!is_numeric($idgroup)) return false;

        $obAccessMenu = self::join('access_menuxgroup', 'access_menu.idmenu', '=', 'access_menuxgroup.idmenu')
        ->where('access_menuxgroup.idgroup', $idgroup)
        ->where('alias', $rota)
        ->select('access_menu.*')
        ->first();
        
        return $obAccessMenu instanceof AccessMenu;
    }

    /**
     * Método responsável por filtrar menus do nivel principal 
     * @method static  getMenuNivelPrincipal
     * @param  integer $idgroup
     * @return [AccessMenu]
     */
    public static function getMenuNivelPrincipal($idgroup = 0){
        if($idgroup == 0) return self::where('level', 0)
        ->orderBy('order')
        ->get();

        return self::join('access_menuxgroup', 'access_menu.idmenu', '=', 'access_menuxgroup.idmenu')
        ->where('access_menuxgroup.idgroup', $idgroup)
        ->where('level', 0)
        ->select('access_menu.*')
        ->orderBy('order')
        ->get();
    }

    /**
     * Método responsável por filtrar menus do nivel principal 
     * @method static  getMenuPorNivel
     * @param  string  $nivel
     * @param  integer $idgroup
     * @return [AccessMenu]
     */
    public static function getMenuPorNivel($nivel, $idgroup = 0){
        if($idgroup == 0) return self::getMenuPorFiltro(['level', '=', $nivel ?? '']);

        return self::join('access_menuxgroup', 'access_menu.idmenu', '=', 'access_menuxgroup.idmenu')
        ->where('access_menuxgroup.idgroup', $idgroup)
        ->where('level', $nivel)
        ->select('access_menu.*')
        ->orderBy('order')
        ->get();
    }

    /**
     * Método responsável por retornar todos os niveis de menu
     * @method static  getAllNiveis()
     * @return array
     */
    public static function getAllNiveis(){
        return self::where('level', '!=', '')
        ->orderBy('order')
        ->get();
    }

    /**
     * Método responsável por retornar todos os menus com filtragem
     * @method static getMenuPorFiltro
     * @param  array $where [condicao1, condicao2]
     * @return [AccessMenu]
     */
    public static function getMenuPorFiltro($where = []){
        return self::getListagem([$where]);
    }

    /**
     * Método responsável por retornar a listagem dos menus
     * @method static getListagem
     * @param array $request
     * @return [AccessMenu]
     */
    public static function getListagem($request = []){
        $obAccessMenu = new self;

        if(!empty($request)){
            foreach($request as $key => $data){
                $obAccessMenu->where($data[0], $data[1], $data[2]);
            }
        }

        return $obAccessMenu->get();
    }

    /**
     * Método responsável por retornar se o grupo é válido com a página
     * @method checkAccess
     * @return bool
     */
    public function checkAccess($idgroup){
        return self::verificarVinculoComGrupo($this->page, $idgroup);
    }

    /**
     * Método responsável por retornar se o grupo é válido com a página por id
     * @method checkAccess
     * @return bool
     */
    public function checkAccessForId($idgroup){
        if(!is_numeric($idgroup)) return false;

        $obAccessMenu = self::join('access_menuxgroup', 'access_menu.idmenu', '=', 'access_menuxgroup.idmenu')
        ->where('access_menuxgroup.idgroup', $idgroup)
        ->where('access_menu.idmenu', $this->idmenu)
        ->select('access_menu.*')
        ->first();
        
        return $obAccessMenu instanceof AccessMenu;
    }

    /**
     * Método responsável por deletar o vinculo por menu
     * @method delete
     * @return bool
     */
    public function deleteVinculoPorMenu(){
        return $this->groups()->detach();
    }

    /**
     * Método responsável por vincular o menu aos grupos
     * @method adicionarVinculoComGrupos
     * @param array $grupos
     * @return mixed
     */
    public function adicionarVinculoComGrupos($grupos){
        if(!is_array($grupos) or count($grupos) == 0) return false;

        return $this->groups()->sync($grupos);
    }
}
