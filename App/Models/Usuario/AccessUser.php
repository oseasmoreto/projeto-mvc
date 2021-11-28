<?php

namespace App\Models\Usuario;

use App\Core\Model;
use App\Models\Usuario\AccessGroup;

/**
 * Classe responsável por gerenciar as interações com o banco de dados da tabela access_user
 * @author Oseas Moreto
 */
class AccessUser extends Model
{
    protected $table      = 'access_user';
    protected $primaryKey = 'iduser';
    public $timestamps    = false;
    protected $guarded    = [];

    /**
     * Método responsável por retornar o grupo vinculado
     * @method group
     */
    public function group(){
        return $this->belongsTo(AccessGroup::class, 'idgroup');
    }

    /**
     * Método responsável por retornar o usuário de acordo com usuário e senha
     * @method static getUsuario
     * @param  string $usuario
     * @param  string $senha
     * @return AccessUser
     */
    public static function getUsuario($usuario, $senha){
        return self::where('user', $usuario)->where('password', $senha)->first();
    }

    /**
     * Método responsável por retornar se existe email ja cadastrado na plataforma
     * @method mixed verificarEmailUsuario()
     * @param string  $email
     * @return bool
     */
    public static function verificarEmailUsuario($email){
        if(!strlen($email)) return false;

        $obAccessUser = self::where('email', '=', $email);

        return $obAccessUser->count() > 0;
    }

    /**
     * Método responsável por retornar se existe usuário ja cadastrado na plataforma
     * @method mixed verificarEmailUsuario()
     * @param string  $email
     * @return bool
     */
    public static function verificarUsuario($user){
        if(!strlen($user)) return false;

        $obAccessUser = self::where('user', '=', $user);

        return $obAccessUser->count() > 0;
    }

    /**
     * Método responsável por retornar a listagem dos usuários
     * @method static getListagem
     * @param array $request
     * @return array
     */
    public static function getListagem($request = []){
        $obAccessUser = new AccessUser;

        if(!empty($request)){
            foreach($request as $key => $data){
                $obAccessUser->where($data[0], $data[1], $data[2]);
            }
        }

        return $obAccessUser->get();
    }
}
