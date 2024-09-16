<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacunatorio extends Model
{
    use HasFactory;
    public $table = 'vacunatorios';
    protected $fillable = [
        'zona',
        'direccion',
        'nombre'
    ];
}
