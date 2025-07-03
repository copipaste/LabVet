<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    protected $table = 'mascotas';

    protected $fillable = [
        'nombre',
        'especie',
        'raza',
        'edad',
        'sexo',
        'cliente_id'
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }
}
