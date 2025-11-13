<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class EmpresaController extends Controller
{
    /**
     * Listar todas las empresas
     * - Recupera todos los registros de la tabla empresas.
     * - Retorna la colección en formato JSON.
     */
    public function index()
    {
        $empresas = Empresa::all();
        return response()->json($empresas);
    }

    /**
     * Crear una nueva empresa
     * - Valida los datos recibidos en la petición.
     * - Si la validación falla, retorna un error 422 con los mensajes.
     * - Si pasa la validación, crea un nuevo registro en la base de datos.
     * - Devuelve la empresa creada con código 201 (Created).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'     => 'required|string|max:255',
            'nit'        => 'required|string|max:50|unique:empresas,nit',
            'direccion'  => 'required|string|max:255',
            'ciudad'     => 'required|string|max:100',
            'correo'     => 'required|email|unique:empresas,correo',
            'contraseña' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Encriptar contraseña antes de guardar
        $validatedData = $validator->validated();
        $validatedData['contraseña'] = Hash::make($validatedData['contraseña']);

        $empresa = Empresa::create($validatedData);
        return response()->json($empresa, 201);
    }

    /**
     * Mostrar una empresa específica
     * - Busca la empresa por ID.
     * - Si no existe, retorna un error 404.
     * - Si existe, devuelve la empresa en formato JSON.
     */
    public function show(string $id)
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }

        return response()->json($empresa);
    }

    /**
     * Actualizar una empresa existente
     * - Busca la empresa por ID.
     * - Si no existe, retorna un error 404.
     * - Valida los datos recibidos (opcionales).
     * - Si son válidos, actualiza el registro en la base de datos.
     * - Retorna la empresa actualizada.
     */
    public function update(Request $request, string $id)
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada para editar'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'     => 'string|max:255',
            'nit'        => 'string|max:50|unique:empresas,nit,' . $id,
            'direccion'  => 'string|max:255',
            'ciudad'     => 'string|max:100',
            'correo'     => 'email|unique:empresas,correo,' . $id,
            'contraseña' => 'string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validatedData = $validator->validated();

        // Si se envía nueva contraseña, encriptarla
        if (isset($validatedData['contraseña'])) {
            $validatedData['contraseña'] = Hash::make($validatedData['contraseña']);
        }

        $empresa->update($validatedData);
        return response()->json($empresa);
    }

    /**
     * Eliminar una empresa
     * - Busca la empresa por ID.
     * - Si no existe, retorna un error 404.
     * - Si existe, elimina el registro de la base de datos.
     * - Retorna un mensaje de confirmación.
     */
    public function destroy(string $id)
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada para eliminar'], 404);
        }

        $empresa->delete();
        return response()->json(['message' => 'Empresa eliminada con éxito']);
    }
}
