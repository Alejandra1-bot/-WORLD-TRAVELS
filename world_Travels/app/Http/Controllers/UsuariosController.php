<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Validator;

/**
 * ---------------------------------------------------------
 * Controlador: UsuariosController
 * ---------------------------------------------------------
 * Este controlador gestiona todas las operaciones CRUD
 * relacionadas con la entidad "Usuarios":
 * - Listar usuarios
 * - Crear un nuevo usuario
 * - Consultar un usuario específico
 * - Actualizar un usuario existente
 * - Eliminar un usuario
 */
class UsuariosController extends Controller
{
    /**
     * -----------------------------------------------------
     * Método: index()
     * -----------------------------------------------------
     * Función: Listar todos los usuarios registrados.
     * Flujo:
     * - Recupera todos los registros de la tabla "usuarios".
     * - Retorna la colección completa en formato JSON.
     */
    public function index()
    {
        $usuarios = Usuarios::all();
        return response()->json($usuarios);
    }
    
    /**
     * -----------------------------------------------------
     * Método: store(Request $request)
     * -----------------------------------------------------
     * Función: Crear un nuevo usuario en la base de datos.
     * Flujo:
     * - Valida los datos recibidos desde la petición.
     *   * Campos obligatorios: Nombre, Apellido, Email, Contraseña,
     *     Telefono, Nacionalidad, Fecha_Registro, Rol.
     * - Si falla la validación → responde con error 422.
     * - Si pasa la validación → crea el usuario.
     * - Devuelve el nuevo usuario con código 201 (Created).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'Nombre'         => 'required|string',
            'Apellido'       => 'required|string',
            'Email'          => 'required|string',
            'Contraseña'     => 'required|string',
            'Telefono'       => 'required|string',
            'Nacionalidad'   => 'required|string',
            'Fecha_Registro' => 'required|date',
            'Rol'            => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $usuarios = Usuarios::create($validator->validated());
        return response()->json($usuarios,201);  
    } 

    /**
     * -----------------------------------------------------
     * Método: show(string $id)
     * -----------------------------------------------------
     * Función: Mostrar los datos de un usuario específico.
     * Flujo:
     * - Busca el usuario por su ID.
     * - Si no existe → responde con error 404.
     * - Si existe → retorna los datos del usuario en JSON.
     */
    public function show(string $id)   
    {
        $usuarios = Usuarios::find($id);

        if (!$usuarios) { 
            return response()->json(['menssage'=> 'Usuario no encontrado'], 404);
        }

        return response()->json($usuarios);
    }

    /**
     * -----------------------------------------------------
     * Método: update(Request $request, string $id)
     * -----------------------------------------------------
     * Función: Actualizar la información de un usuario.
     * Flujo:
     * - Busca el usuario por ID.
     * - Si no existe → responde con error 404.
     * - Valida los campos enviados (todos opcionales).
     * - Si falla la validación → responde con error 422.
     * - Si pasa la validación → actualiza el usuario en DB.
     * - Retorna el usuario actualizado en formato JSON.
     */
    public function update(Request $request, string $id)  
    {
        $usuarios = Usuarios::find($id);

        if (!$usuarios) { 
            return response()->json(['menssage'=> 'Usuario no encontrado para editar'], 404);
        }

        $validator = Validator::make($request->all(),[
            'Nombre'         => 'string',
            'Apellido'       => 'string',
            'Email'          => 'string',
            'Contraseña'     => 'string',
            'Telefono'       => 'string',
            'Nacionalidad'   => 'string',
            'Fecha_Registro' => 'date',
            'Rol'            => 'string',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $usuarios->update($validator->validated());
        return response()->json($usuarios); 
    }

    /**
     * -----------------------------------------------------
     * Método: destroy(string $id)
     * -----------------------------------------------------
     * Función: Eliminar un usuario de la base de datos.
     * Flujo:
     * - Busca el usuario por ID.
     * - Si no existe → responde con error 404.
     * - Si existe → elimina el registro.
     * - Retorna mensaje de confirmación en JSON.
     */
    public function destroy (string $id)
    {
        $usuarios = Usuarios::find($id);

        if (!$usuarios) { 
            return response()->json(['menssage'=> 'Usuario no encontrado para eliminar'], 404);
        }

        $usuarios->delete();
        return response()->json(['message' => 'Usuario eliminado con éxito']); 
    } 
}
