<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'bod_proveedor';
    protected $primaryKey  = 'id_bod_proveedor';
    public $timestamps = false;

}
?>