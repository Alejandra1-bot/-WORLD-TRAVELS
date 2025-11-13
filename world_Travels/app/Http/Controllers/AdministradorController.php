<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrador;
use Illuminate\Support\Facades\Validator;

/**
 * ---------------------------------------------------------
 * Controlador: AdministradorController
 * ---------------------------------------------------------
 * Este controlador gestiona todas las operaciones CRUD
 * relacionadas con la entidad "Administrador":
 * - Listar administradores
 * - Crear un nuevo administrador
 * - Consultar un administrador específico
 * - Actualizar un administrador existente
 * - Eliminar un administrador
 */
class AdministradorController extends Controller
{
    /**
     * -----------------------------------------------------
     * Método: index()
     * -----------------------------------------------------
     * Función: Listar todos los administradores registrados.
     * Flujo:
     * - Recupera todos los registros de la tabla "administradores".
     * - Retorna la colección completa en formato JSON.
     */
    public function index()
    {
        $administradores = Administrador::all();
        return response()->json($administradores);
    }

    /**
     * -----------------------------------------------------
     * Método: store(Request $request)
     * -----------------------------------------------------
     * Función: Crear un nuevo administrador en la base de datos.
     * Flujo:
     * - Valida los datos recibidos desde la petición.
     *   * Campos obligatorios: nombre, apellido, telefono, correo, documento, contraseña.
     * - Si falla la validación → responde con error 422.
     * - Si pasa la validación → crea el administrador.
     * - Devuelve el nuevo administrador con código 201 (Created).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nombre'     => 'required|string',
            'apellido'   => 'required|string',
            'telefono'   => 'required|string',
            'correo'     => 'required|string|email|unique:administradores',
            'documento'  => 'required|string|unique:administradores',
            'contraseña' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $administrador = Administrador::create($validator->validated());
        return response()->json($administrador, 201);
    }

    /**
     * -----------------------------------------------------
     * Método: show(string $id)
     * -----------------------------------------------------
     * Función: Mostrar los datos de un administrador específico.
     * Flujo:
     * - Busca el administrador por su ID.
     * - Si no existe → responde con error 404.
     * - Si existe → retorna los datos del administrador en JSON.
     */
    public function show(string $id)
    {
        $administrador = Administrador::find($id);

        if (!$administrador) {
            return response()->json(['message' => 'Administrador no encontrado'], 404);
        }

        return response()->json($administrador);
    }

    /**
     * -----------------------------------------------------
     * Método: update(Request $request, string $id)
     * -----------------------------------------------------
     * Función: Actualizar la información de un administrador.
     * Flujo:
     * - Busca el administrador por ID.
     * - Si no existe → responde con error 404.
     * - Valida los campos enviados (todos opcionales).
     * - Si falla la validación → responde con error 422.
     * - Si pasa la validación → actualiza el administrador en DB.
     * - Retorna el administrador actualizado en formato JSON.
     */
    public function update(Request $request, string $id)
    {
        $administrador = Administrador::find($id);

        if (!$administrador) {
            return response()->json(['message' => 'Administrador no encontrado para editar'], 404);
        }

        $validator = Validator::make($request->all(),[
            'nombre'     => 'string',
            'apellido'   => 'string',
            'telefono'   => 'string',
            'correo'     => 'string|email|unique:administradores,correo,' . $id,
            'documento'  => 'string|unique:administradores,documento,' . $id,
            'contraseña' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $administrador->update($validator->validated());
        return response()->json($administrador);
    }

    /**
     * -----------------------------------------------------
     * Método: destroy(string $id)
     * -----------------------------------------------------
     * Función: Eliminar un administrador de la base de datos.
     * Flujo:
     * - Busca el administrador por ID.
     * - Si no existe → responde con error 404.
     * - Si existe → elimina el registro.
     * - Retorna mensaje de confirmación en JSON.
     */
    public function destroy(string $id)
    {
        $administrador = Administrador::find($id);

        if (!$administrador) {
            return response()->json(['message' => 'Administrador no encontrado para eliminar'], 404);
        }

        $administrador->delete();
        return response()->json(['message' => 'Administrador eliminado con éxito']);
    }
}
