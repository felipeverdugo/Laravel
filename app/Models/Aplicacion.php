<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Node\Stmt\Return_;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class Aplicacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'aplicaciones';

    protected $dates = [
        'fecha_aplicacion',
        'fecha_turno',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $fillable = [
        'user_id',
        'vacuna_id',
        'fecha_aplicacion',
        'estado',
        'fecha_turno',
        'created_at',
        'updated_at',
        'deleted_at',
        'vacunatorio_id',
        'lote',
        'laboratorio',
        'obs',
    ];
    protected $attributes = [
        'estado' => 'PENDIENTE'
    ];

    public function getFechaSolicitudAttribute()
    {
        return $this->created_at? $this->created_at->format('d-m-Y'):'No aplica';
    }

    public function vacunatorio(): BelongsTo
    {
        return $this->belongsTo(Vacunatorio::class, 'vacunatorio_id');
    }

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vacuna(): BelongsTo
    {
        return $this->belongsTo(Vacuna::class, 'vacuna_id');
    }

    public function puedeAnular()
    {
        if ($this->estado === "PENDIENTE") {
            return true;
        }
        return false;
    }
}
