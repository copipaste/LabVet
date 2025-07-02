<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';

    protected $fillable = [
        'monto',
        'fecha',
        'orden_analisis_id',
        'usuario_id',
    ];


}
