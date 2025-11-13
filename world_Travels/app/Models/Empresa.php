<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Empresa extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = [
        'nit',
        'nombre',
        'direccion',
        'ciudad',
        'correo',
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
            'nit' => 'required|string|max:20|unique:empresas,nit,' . $id,
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:empresas,correo,' . $id,
            'contraseña' => $id ? 'nullable|string|min:8' : 'required|string|min:8'
        ];
    }
}
