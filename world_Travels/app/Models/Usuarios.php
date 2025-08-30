<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
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
