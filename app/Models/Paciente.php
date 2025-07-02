<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paciente extends Model
{
    protected $table = 'mascotas';

    protected $fillable = [
        'nombre',
        'especie',
        'raza',
        'edad',
        'sexo',
        'cliente_id',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }
}
