<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veterinaria extends Model
{
    protected $table = 'veterinarias';

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email'
    ];
}
