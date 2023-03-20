<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class DetalleIngresoProdModel extends Model
{
    protected $table = 'det_ingreso_producto';
    protected $primaryKey  = 'id_det_ingreso_producto ';
    public $timestamps = false;

}
?>