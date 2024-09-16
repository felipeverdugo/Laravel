<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasRoles;
    use Impersonate;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_token',
        'dni',
        'last_name',
        'fecha_nac',
        'vacunatorio_id',
    ];
    public $sortable = [
        'name',
        'email',
        'dni',
        'last_name',
        'fecha_nac',
        'vacunatorio_id',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'blocked_at' => 'datetime'
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function getNombreCompletoAttribute()
    {
        return $this->name . ' ' . $this->last_name;
    }

    public function getBlockedAttribute()
    {
        return $this->blocked_at !== null;
    }

    public function setBlockedAttribute($blocked)
    {
        $this->blocked_at = $blocked ? now() : null;
    }

    public function getTieneAplicacionesAttribute()
    {
        return $this->aplicaciones()->exists();
    }

    public function aplicaciones(): HasMany
    {
        return $this->hasMany(Aplicacion::class, 'user_id');
    }

    public function vacunatorio(): BelongsTo
    {
        return $this->belongsTo(Vacunatorio::class, 'vacunatorio_id');
    }

    public function scopeAplicacionesNoPendientes(): HasMany
    {
        return $this->aplicaciones()->where('estado', '!=', 'PENDIENTE');
    }

    public function scopeAplicacionesPendientes(): HasMany
    {
        return $this->aplicaciones()->where('estado', 'PENDIENTE');
    }
}
