<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenAnalisis extends Model
{
    protected $table = 'ordenesanalisis'; // <- ajustado al nombre real si no usás snake_case

    protected $fillable = [
        'mascota_id',
        'veterinaria_id',
        'fecha_solicitud',
        'estado',
        'observaciones',
        'promocion_id',
        'total'
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }

    public function veterinaria()
    {
        return $this->belongsTo(Veterinaria::class);
    }

    public function promocion()
    {
        return $this->belongsTo(Promocion::class);
    }

        public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'ordenes_servicios', 'orden_id', 'servicio_id');
    }

}
