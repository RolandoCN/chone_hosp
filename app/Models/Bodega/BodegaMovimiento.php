<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class BodegaMovimiento extends Model
{
    protected $table = 'bod_movimiento';
    protected $primaryKey  = 'id_bod_movimiento';
    public $timestamps = false;

}
?>