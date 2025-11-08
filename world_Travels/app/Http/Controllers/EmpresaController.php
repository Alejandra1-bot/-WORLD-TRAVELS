<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\Support\Facades\Validator;

/**
 * ---------------------------------------------------------
 * Controlador: EmpresaController
 * ---------------------------------------------------------
 * Este controlador gestiona todas las operaciones CRUD
 * relacionadas con la entidad "Empresa":
 * - Listar empresas
 * - Crear una nueva empresa
 * - Consultar una empresa específica
 * - Actualizar una empresa existente
 * - Eliminar una empresa
 */
class EmpresaController extends Controller
{
    /**
     * -----------------------------------------------------
     * Método: index()
     * -----------------------------------------------------
     * Función: Listar todas las empresas registradas.
     * Flujo:
     * - Recupera todos los registros de la tabla "empresas".
     * - Retorna la colección completa en formato JSON.
     */
    public function index()
    {
        $empresas = Empresa::all();
        return response()->json($empresas);
    }

    /**
     * -----------------------------------------------------
     * Método: store(Request $request)
     * -----------------------------------------------------
     * Función: Crear una nueva empresa en la base de datos.
     * Flujo:
     * - Valida los datos recibidos desde la petición.
     *   * Campos obligatorios: nombre, nit, direccion, ciudad.
     * - Si falla la validación → responde con error 422.
     * - Si pasa la validación → crea la empresa.
     * - Devuelve la nueva empresa con código 201 (Created).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nombre'    => 'required|string',
            'nit'       => 'required|string|unique:empresas',
            'direccion' => 'required|string',
            'ciudad'    => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $empresa = Empresa::create($validator->validated());
        return response()->json($empresa, 201);
    }

    /**
     * -----------------------------------------------------
     * Método: show(string $id)
     * -----------------------------------------------------
     * Función: Mostrar los datos de una empresa específica.
     * Flujo:
     * - Busca la empresa por su ID.
     * - Si no existe → responde con error 404.
     * - Si existe → retorna los datos de la empresa en JSON.
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
     * -----------------------------------------------------
     * Método: update(Request $request, string $id)
     * -----------------------------------------------------
     * Función: Actualizar la información de una empresa.
     * Flujo:
     * - Busca la empresa por ID.
     * - Si no existe → responde con error 404.
     * - Valida los campos enviados (todos opcionales).
     * - Si falla la validación → responde con error 422.
     * - Si pasa la validación → actualiza la empresa en DB.
     * - Retorna la empresa actualizada en formato JSON.
     */
    public function update(Request $request, string $id)
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada para editar'], 404);
        }

        $validator = Validator::make($request->all(),[
            'nombre'    => 'string',
            'nit'       => 'string|unique:empresas,nit,' . $id,
            'direccion' => 'string',
            'ciudad'    => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $empresa->update($validator->validated());
        return response()->json($empresa);
    }

    /**
     * -----------------------------------------------------
     * Método: destroy(string $id)
     * -----------------------------------------------------
     * Función: Eliminar una empresa de la base de datos.
     * Flujo:
     * - Busca la empresa por ID.
     * - Si no existe → responde con error 404.
     * - Si existe → elimina el registro.
     * - Retorna mensaje de confirmación en JSON.
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