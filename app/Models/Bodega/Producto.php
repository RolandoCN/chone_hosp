<?php

namespace App\Models\Bodega;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'bod_producto';
    protected $primaryKey  = 'idbod_producto';
    public $timestamps = false;

}
?>