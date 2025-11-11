<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorias_Actividades;
use Illuminate\Support\Facades\Validator;

class Categorias_ActividadesController extends Controller
{
    /**
     * Listar todas las categorías de actividades
     * - Obtiene todas las categorías de la base de datos.
     * - Retorna la colección completa en formato JSON.
     */
    public function index()
    {
        $categorias = Categorias_Actividades::all();
        return response()->json($categorias);
    }

    /**
     * Crear una nueva categoría
     * - Valida los datos recibidos en la petición.
     * - Si los datos no son válidos, retorna error 422.
     * - Si son válidos, inserta una nueva categoría en la base de datos.
     * - Retorna la categoría creada con código 201 (Created).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Nombre_Categoria' => 'required|string|max:255|unique:categorias__actividades',
            'Descripcion'      => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $categoria = Categorias_Actividades::create($validator->validated());
        return response()->json($categoria, 201);
    }

    /**
     * Mostrar una categoría específica
     * - Busca la categoría por su ID.
     * - Si no existe, retorna un error 404.
     * - Si existe, devuelve la información en formato JSON.
     */
    public function show(string $id)
    {
        $categoria = Categorias_Actividades::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        return response()->json($categoria);
    }

    /**
     * Actualizar una categoría existente
     * - Busca la categoría por ID.
     * - Si no existe, retorna un error 404.
     * - Valida los campos recibidos (todos opcionales).
     * - Si son válidos, actualiza el registro en la base de datos.
     * - Retorna la categoría actualizada.
     */
    public function update(Request $request, string $id)
    {
        $categoria = Categorias_Actividades::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada para editar'], 404);
        }

        $validator = Validator::make($request->all(), [
            'Nombre_Categoria' => 'string|max:255|unique:categorias__actividades,nombre_categoria,'.$id,
            'Descripcion'      => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $categoria->update($validator->validated());
        return response()->json($categoria);
    }

    /**
     * Eliminar una categoría
     * - Busca la categoría por su ID.
     * - Si no existe, retorna un error 404.
     * - Si existe, elimina el registro de la base de datos.
     * - Devuelve un mensaje de confirmación.
     */
    public function destroy(string $id)
    {
        $categoria = Categorias_Actividades::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada para eliminar'], 404);
        }

        $categoria->delete();
        return response()->json(['message' => 'Categoría eliminada con éxito']);
    }
}
