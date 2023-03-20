<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class CabeceraIngresoProdModel extends Model
{
    protected $table = 'bod_cab_ingreso_producto';
    protected $primaryKey  = 'id_cab_ingreso_producto';
    public $timestamps = false;

}
?>