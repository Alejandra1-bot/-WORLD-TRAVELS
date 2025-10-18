<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Municipios;
use Illuminate\Support\Facades\Validator;

class MunicipiosController extends Controller
{
    /**
     * Listar todos los municipios
     * - Recupera todos los registros de la tabla municipios.
     * - Retorna la colección en formato JSON.
     */
    public function index()
    {
        $municipios = Municipios::all();
        return response()->json($municipios);
    }

    /**
     * Crear un nuevo municipio
     * - Valida los datos recibidos en la petición.
     * - Si la validación falla, retorna un error 422 con los mensajes.
     * - Si pasa la validación, crea un nuevo registro en la base de datos.
     * - Devuelve el municipio creado con código 201 (Created).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Nombre'         => 'required|string',
            'idDepartamento' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $municipios = Municipios::create($validator->validated());
        return response()->json($municipios, 201);
    }

    /**
     * Mostrar un municipio específico
     * - Busca el municipio por ID.
     * - Si no existe, retorna un error 404.
     * - Si existe, devuelve el municipio en formato JSON.
     */
    public function show(string $id)
    {
        $municipios = Municipios::find($id);

        if (!$municipios) {
            return response()->json(['menssage' => 'Municipio no encontrado'], 404);
        }

        return response()->json($municipios);
    }

    /**
     * Actualizar un municipio existente
     * - Busca el municipio por ID.
     * - Si no existe, retorna un error 404.
     * - Valida los datos recibidos (opcionales).
     * - Si son válidos, actualiza el registro en la base de datos.
     * - Retorna el municipio actualizado.
     */
    public function update(Request $request, string $id)
    {
        $municipios = Municipios::find($id);

        if (!$municipios) {
            return response()->json(['menssage' => 'Municipio no encontrado para editar'], 404);
        }

        $validator = Validator::make($request->all(), [
            'Nombre'         => 'string',
            'idDepartamento' => 'integer',
            'idActividad'    => 'integer', // Si este campo no existe en la BD, habría que quitarlo
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $municipios->update($validator->validated());
        return response()->json($municipios);
    }

    /**
     * Eliminar un municipio
     * - Busca el municipio por ID.
     * - Si no existe, retorna un error 404.
     * - Si existe, elimina el registro de la base de datos.
     * - Retorna un mensaje de confirmación.
     */
    public function destroy(string $id)
    {
        $municipios = Municipios::find($id);

        if (!$municipios) {
            return response()->json(['menssage' => 'Municipio no encontrado para eliminar'], 404);
        }

        $municipios->delete();
        return response()->json(['message' => 'Municipio eliminado con éxito']);
    }
}
