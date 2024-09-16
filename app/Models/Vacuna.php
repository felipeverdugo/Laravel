<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacuna extends Model
{
    public $timestamps = false;

    public $table = 'vacunas';
    
    protected $fillable = [
        'nombre',
        'restriccion_etarea',
        'distancia_dosis',
        'requiere_validacion',
    ];
}
