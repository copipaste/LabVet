<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $table = 'insumos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'cantidad',
    ];

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'servicio_insumo', 'insumo_id', 'servicio_id');
    }
}
