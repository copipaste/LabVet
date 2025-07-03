<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    public $timestamps = true;

    protected $fillable = [
        'orden_id',
        'fecha_pago',
        'monto',
        'metodo_pago',
        'estado',
    ];

    public function orden()
    {
        return $this->belongsTo(OrdenAnalisis::class, 'orden_id');
    }
}
