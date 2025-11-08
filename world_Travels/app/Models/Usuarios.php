<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuarios extends Authenticatable implements JWTSubject
{
    protected $table = 'usuarios';

    protected $fillable = [
        'Nombre',
        'Apellido',
        'Email',
        'Contraseña',
        'Telefono',
        'Nacionalidad',
        'Fecha_Registro',
        'Rol'
    ];

    protected $hidden = [
        'Contraseña',
        'remember_token',
    ];

    // Métodos requeridos por JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

     public function reservas()
    {
        return $this->hasMany(Reservas::class, 'idUsuario');
    }

    // Relación: un usuario puede crear muchas actividades
    public function actividades()
    {
        return $this->hasMany(Actividades::class, 'idUsuario');
    }

    // Relación: un usuario puede hacer muchos comentarios
    public function comentarios()
    {
        return $this->hasMany(Comentarios::class, 'idUsuario');
    }
}
