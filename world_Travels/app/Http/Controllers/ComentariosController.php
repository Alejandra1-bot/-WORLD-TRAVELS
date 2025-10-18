<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentarios;
use Illuminate\Support\Facades\Validator;

class ComentariosController extends Controller
{
    /**
     * Listar todos los comentarios
     * - Obtiene todos los registros de la tabla comentarios.
     * - Devuelve la lista completa en formato JSON.
     */
    public function index()
    {
        $comentarios = Comentarios::all();
        return response()->json($comentarios);
    }

    /**
     * Crear un nuevo comentario
     * - Valida los datos recibidos en la petición.
     * - Si la validación falla, devuelve error 422.
     * - Si es válida, inserta un nuevo registro en la base de datos.
     * - Devuelve el comentario creado con código 201 (Created).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idUsuario'       => 'required|integer',
            'idActividad'     => 'required|integer',
            'contenido'       => 'required|string',
            'fechaComentario' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $comentario = Comentarios::create($validator->validated());
        return response()->json($comentario, 201);
    }

    /**
     * Mostrar un comentario específico
     * - Busca un comentario por su ID.
     * - Si no existe, devuelve error 404.
     * - Si existe, retorna el comentario en formato JSON.
     */
    public function show(string $id)
    {
        $comentario = Comentarios::find($id);

        if (!$comentario) {
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }

        return response()->json($comentario);
    }

    /**
     * Actualizar un comentario existente
     * - Busca el comentario por ID.
     * - Si no existe, retorna error 404.
     * - Valida los datos recibidos (todos opcionales).
     * - Si son válidos, actualiza el registro en la base de datos.
     * - Retorna el comentario actualizado.
     */
    public function update(Request $request, string $id)
    {
        $comentario = Comentarios::find($id);

        if (!$comentario) {
            return response()->json(['message' => 'Comentario no encontrado para editar'], 404);
        }

        $validator = Validator::make($request->all(), [
            'idUsuario'       => 'integer',
            'idActividad'     => 'integer',
            'contenido'       => 'string',
            'fechaComentario' => 'date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $comentario->update($validator->validated());
        return response()->json($comentario);
    }

    /**
     * Eliminar un comentario
     * - Busca el comentario por ID.
     * - Si no existe, retorna error 404.
     * - Si existe, elimina el registro de la base de datos.
     * - Devuelve un mensaje de confirmación.
     */
    public function destroy(string $id)
    {
        $comentario = Comentarios::find($id);

        if (!$comentario) {
            return response()->json(['message' => 'Comentario no encontrado para eliminar'], 404);
        }

        $comentario->delete();
        return response()->json(['message' => 'Comentario eliminado con éxito']);
    }
}
