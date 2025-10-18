<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo Actividades
 *
 * Representa las actividades turísticas o recreativas dentro del sistema.
 * Cada actividad está relacionada con una categoría, un usuario, un municipio
 * y puede tener múltiples reservas y comentarios.
 *
 * @package App\Models
 */
class Actividades extends Model
{
    /**
     * Nombre de la tabla asociada en la base de datos.
     *
     * @var string
     */
    protected $table = 'actividades';

    /**
     * Campos que se pueden asignar de manera masiva (mass assignment).
     * Estos corresponden a las columnas de la tabla.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre_actividad', // Nombre de la actividad
        'descripcion',      // Descripción de la actividad
        'fecha',            // Fecha programada
        'hora',             // Hora programada
        'precio',           // Precio por persona
        'cupo_maximo',      // Número máximo de participantes
        'ubicacion',        // Dirección o lugar de la actividad
        'imagen',           // Ruta o URL de la imagen asociada
        'idCategoria',      // Relación con la tabla categorias_actividades
        'idUsuario',        // Relación con la tabla usuarios
        'idMunicipio'       // Relación con la tabla municipios
    ];

    /**
     * Relación con Categorias_Actividades.
     * Una actividad pertenece a una categoría.
     *
     * @return BelongsTo
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categorias_Actividades::class, 'idCategoria');
    }

    /**
     * Relación con Usuarios.
     * Una actividad pertenece a un usuario (quien la creó o administra).
     *
     * @return BelongsTo
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuarios::class, 'idUsuario');
    }

    /**
     * Relación con Municipios.
     * Una actividad está ubicada dentro de un municipio.
     *
     * @return BelongsTo
     */
    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipios::class, 'idMunicipio');
    }

    /**
     * Relación con Reservas.
     * Una actividad puede tener muchas reservas.
     *
     * @return HasMany
     */
    public function reservas(): HasMany
    {
        return $this->hasMany(Reservas::class, 'idActividad');
    }

    /**
     * Relación con Comentarios.
     * Una actividad puede tener muchos comentarios.
     *
     * @return HasMany
     */
    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentarios::class, 'idActividad');
    }
}