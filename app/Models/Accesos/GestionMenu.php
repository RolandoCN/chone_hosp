<?php

namespace App\Models\Accesos;

use Illuminate\Database\Eloquent\Model;

class GestionMenu extends Model
{
    protected $table = 'gestion_menu';
    protected $primaryKey  = 'id_gestion_menu';
    public $timestamps = false;

    public function gestion(){
        return $this->belongsTo('App\Models\Accesos\Gestion', 'id_gestion', 'id_gestion');
    }


    public function menu(){
        return $this->belongsTo('App\Models\Accesos\Menu', 'id_menu', 'id_menu');
    }

}
?>