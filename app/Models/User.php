<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'DNI',
        'name',
        'apellido_paterno',
        'apellido_materno',
        'direccion',
        'Celular',
        'email',
        'password',
        'Puntos',
        'rol'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'DNI' => 'integer',
        'Celular' => 'integer',
        'Puntos' => 'integer'
    ];

    /**
     * Relación: un usuario tiene muchos canjes
     */
    public function canjes()
    {
        return $this->hasMany(Canje::class, 'DNI_usuario', 'DNI');
    }
    public function residuos()
{
    return $this->hasMany(Residuo::class);
}

}
