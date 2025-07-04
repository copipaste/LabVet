<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $table = 'insumos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'cantidad_disponible',
        'unidad_medida',
        'fecha_caducidad',
        'tipo',
        'categoria_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
  
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'servicio_insumo', 'insumo_id', 'servicio_id');
    }
}
