<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    /**
     * Nombre de la tabla asociada en la base de datos
     */
    protected $table = 'usuarios';

    /**
     * Campos que se pueden asignar de manera masiva (mass assignment).
     */
    protected $fillable = [
        'Nombre',          // Nombre del usuario
        'Apellido',        // Apellido del usuario
        'Email',           // Correo electrónico
        'Contraseña',      // Contraseña (⚠️ recomendable cambiar a "password" sin tilde)
        'Telefono',        // Número de teléfono
        'Nacionalidad',    // País de origen
        'Fecha_Registro',  // Fecha en que se registró el usuario
        'Rol'              // Rol dentro del sistema (ej: admin, cliente)
    ];

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
