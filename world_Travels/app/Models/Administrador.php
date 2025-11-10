<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Administrador extends Authenticatable implements JWTSubject
{
    protected $table = 'administradores';

    protected $fillable = [
        'nombre',
        'apellido',
        'correo_electronico',
        'telefono',
        'documento',
        'contraseña'
    ];

    protected $hidden = [
        'contraseña',
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

    // Método para obtener la contraseña (necesario para JWT)
    public function getAuthPassword()
    {
        return $this->contraseña;
    }

    // Método para obtener el identificador de autenticación
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    // Método para obtener el identificador de autenticación
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    // Reglas de validación
    public static function rules($id = null)
    {
        return [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo_electronico' => 'required|string|email|max:255|unique:administradores,correo_electronico,' . $id,
            'telefono' => 'required|string|max:20',
            'documento' => 'required|string|max:20|unique:administradores,documento,' . $id,
            'contraseña' => $id ? 'nullable|string|min:8' : 'required|string|min:8'
        ];
    }
}
