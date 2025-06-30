<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    

protected $table = 'promociones';

    protected $fillable = [
        'nombre', 'descripcion', 'descuento', 'fecha_inicio', 'fecha_fin', 'activa'
    ];
}
