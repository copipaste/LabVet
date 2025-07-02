<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenesAnalisis extends Model
{
    protected $table = 'ordenesanalisis';

    protected $fillable = [
        'fecha',
        'paciente_id',
        'usuario_id',
        'estado',
    ];


}
