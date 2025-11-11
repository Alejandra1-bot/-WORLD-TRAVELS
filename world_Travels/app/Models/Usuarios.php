<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuarios extends Model implements JWTSubject
{
    /**
     * Nombre de la tabla asociada en la base de datos
     */
    protected $table = 'usuarios';

    /**
     * Campos que se pueden asignar de manera masiva (mass assignment).
     */
    protected $fillable = [
        'Nombre',
        'Apellido',
        'Email',
        'Contraseña',
        'Telefono',
        'Nacionalidad',
        'Fecha_Registro',
        'Rol',
        'is_blocked'
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

    /**
     * Mutator para encriptar automáticamente la contraseña.
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['Contraseña'] = Hash::make($value);
    }

    /**
     * Relación con Reservas
     * Un usuario puede tener muchas reservas.
     */
    public function reservas()
    {
        return $this->hasMany(Reservas::class, 'idUsuario');
    }

    /**
     * Relación con Actividades
     * Un usuario puede crear muchas actividades.
     */
    public function actividades()
    {
        return $this->hasMany(Actividades::class, 'idUsuario');
    }

    /**
     * Relación con Comentarios
     * Un usuario puede hacer muchos comentarios.
     */
    public function comentarios()
    {
        return $this->hasMany(Comentarios::class, 'idUsuario');
    }
}
