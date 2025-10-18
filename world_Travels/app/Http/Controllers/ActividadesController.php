<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividades;
use Illuminate\Support\Facades\Validator;

class ActividadesController extends Controller
{
    /**
     * Muestra todas las actividades
     * - Obtiene todas las actividades desde la base de datos.
     * - Retorna la lista completa en formato JSON.
     */
    public function index()
    {
        $actividades = Actividades::all();
        return response()->json($actividades);
    }

    /**
     * Crea una nueva actividad
     * - Valida los datos enviados en la petición.
     * - Si hay errores de validación, devuelve código 422.
     * - Si es válido, inserta el registro en la base de datos.
     * - Retorna la actividad creada con código 201 (Created).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idCategoria'  => 'required|integer',
            'idUsuario'    => 'required|integer',
            'idMunicipio'  => 'required|integer',
            'titulo'       => 'required|string|max:255',
            'descripcion'  => 'required|string',
            'fecha'        => 'required|date',
            'hora'         => 'required',
            'precio'       => 'required|numeric|min:0',
            'cupoMaximo'   => 'required|integer|min:1',
            'ubicacion'    => 'required|string|max:255',
            'imagen'       => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $actividad = Actividades::create($validator->validated());
        return response()->json($actividad, 201);
    }

    /**
     * Muestra una actividad específica
     * - Busca la actividad por su ID.
     * - Si no existe, devuelve error 404.
     * - Si existe, retorna la información en JSON.
     */
    public function show(string $id)
    {
        $actividad = Actividades::find($id);

        if (!$actividad) {
            return response()->json(['message' => 'Actividad no encontrada'], 404);
        }

        return response()->json($actividad);
    }

    /**
     * Actualiza una actividad existente
     * - Busca la actividad por ID.
     * - Si no existe, devuelve error 404.
     * - Valida los campos enviados (todos opcionales).
     * - Si son válidos, actualiza el registro en la base de datos.
     * - Retorna la actividad actualizada.
     */
    public function update(Request $request, string $id)
    {
        $actividad = Actividades::find($id);

        if (!$actividad) {
            return response()->json(['message' => 'Actividad no encontrada para editar'], 404);
        }

        $validator = Validator::make($request->all(), [
            'idCategoria'  => 'integer',
            'idUsuario'    => 'integer',
            'idMunicipio'  => 'integer',
            'titulo'       => 'string|max:255',
            'descripcion'  => 'string',
            'fecha'        => 'date',
            'hora'         => '',
            'precio'       => 'numeric|min:0',
            'cupoMaximo'   => 'integer|min:1',
            'ubicacion'    => 'string|max:255',
            'imagen'       => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $actividad->update($validator->validated());
        return response()->json($actividad);
    }

    /**
     * Elimina una actividad
     * - Busca la actividad por ID.
     * - Si no existe, devuelve error 404.
     * - Si existe, elimina el registro de la base de datos.
     * - Retorna un mensaje de confirmación.
     */
    public function destroy(string $id)
    {
        $actividad = Actividades::find($id);

        if (!$actividad) {
            return response()->json(['message' => 'Actividad no encontrada para eliminar'], 404);
        }

        $actividad->delete();
        return response()->json(['message' => 'Actividad eliminada con éxito']);
    }
}
