<?php

namespace App\Models\Accesos;

use Illuminate\Database\Eloquent\Model;

class PerfilAcceso extends Model
{
    protected $table = 'perfil_acceso';
    protected $primaryKey  = 'id_perfil_acceso';
    public $timestamps = false;

    public function menu(){
        return $this->belongsTo('App\Models\Accesos\Menu', 'id_menu', 'id_menu');
    }
}
?>