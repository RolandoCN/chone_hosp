<?php

namespace App\Models\Accesos;

use Illuminate\Database\Eloquent\Model;

class UsuarioPerfil extends Model
{
    protected $table = 'perfil_usuario';
    protected $primaryKey  = 'idperfil_usuario';
    public $timestamps = false;

    public function nombre_perfil(){
        return $this->belongsTo('App\Models\Accesos\Perfil', 'id_perfil', 'id_perfil')->where('estado', 'A');
    }
}
?>