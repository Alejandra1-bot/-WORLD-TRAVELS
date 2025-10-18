<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorias_Actividades extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'categorias_actividades';

    // Campos que se pueden asignar de manera masiva (mass assignment)
    protected $fillable = [
        'nombre_categoria', // Nombre de la categoría
        'descripcion'       // Descripción de la categoría
    ];
}
