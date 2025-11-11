<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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
            'Contrasena'     => 'required|string|min:8',
            'Telefono'       => 'required|string',
            'Nacionalidad'   => 'required|string',
            'Fecha_Registro' => 'required|date',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

         $data = $validator->validated();
         $data['Contraseña'] = Hash::make($data['Contrasena']);

         // Crear usuario en tabla users
         $user = User::create([
             'name' => $data['Nombre'] . ' ' . $data['Apellido'],
             'email' => $data['Email'],
             'password' => $data['Contraseña'],
             'role' => 'usuario',
         ]);

        $usuarios = Usuarios::create([
            'Nombre' => $data['Nombre'],
            'Apellido' => $data['Apellido'],
            'Email' => $data['Email'],
            'Contraseña' => $data['Contraseña'],
            'Telefono' => $data['Telefono'],
            'Nacionalidad' => $data['Nacionalidad'],
            'Fecha_Registro' => $data['Fecha_Registro'],
        ]);
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
            'Nombre' => 'string|max:255',
            'Apellido' => 'string|max:255',
            'Email' => 'string|email|max:255|unique:usuarios,email,'.$id,
            'Contrasena' => 'string|min:8',
            'Telefono' => 'string|max:20',
            'Nacionalidad' => 'string|max:255',
            'Rol' => 'string|in:Turista,Guía Turístico,Administrador',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $oldEmail = $usuarios->Email;
        $oldNombre = $usuarios->Nombre;
        $oldApellido = $usuarios->Apellido;

        $data = $validator->validated();
        if (isset($data['Contrasena'])) {
            $data['Contraseña'] = Hash::make($data['Contrasena']);
            unset($data['Contrasena']);
        }

        $usuarios->update($data);

        // Actualizar también en tabla users
        $user = User::where('email', $oldEmail)->first();
        if ($user) {
            $userData = [];
            if (isset($data['Nombre']) || isset($data['Apellido'])) {
                $userData['name'] = ($data['Nombre'] ?? $oldNombre) . ' ' . ($data['Apellido'] ?? $oldApellido);
            }
            if (isset($data['Contraseña'])) {
                $userData['password'] = $data['Contraseña'];
            }
            // Para email, verificar que no exista otro con el mismo email
            if (isset($data['Email'])) {
                $newEmail = $data['Email'];
                $existing = User::where('email', $newEmail)->where('id', '!=', $user->id)->exists();
                if (!$existing) {
                    $userData['email'] = $newEmail;
                }
            }

            if (!empty($userData)) {
                $user->update($userData);
            }
        }

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

        // Eliminar también de tabla users
        $user = User::where('email', $usuarios->Email)->first();
        if ($user) {
            $user->delete();
        }

        $usuarios->delete();
        return response()->json(['message' => 'Usuario eliminado con éxito']);
    }

    /**
     * -----------------------------------------------------
     * Método: bloquear(string $id)
     * -----------------------------------------------------
     * Función: Bloquear o desbloquear un usuario.
     * Flujo:
     * - Busca el usuario por ID.
     * - Si no existe → responde con error 404.
     * - Cambia el estado de is_blocked.
     * - Actualiza también en tabla users.
     * - Retorna mensaje de confirmación.
     */
    public function bloquear(string $id)
    {
        $usuarios = Usuarios::find($id);

        if (!$usuarios) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $nuevoEstado = !$usuarios->is_blocked;
        $usuarios->update(['is_blocked' => $nuevoEstado]);

        // Actualizar también en tabla users
        $user = User::where('email', $usuarios->Email)->first();
        if ($user) {
            $user->update(['is_blocked' => $nuevoEstado]);
        }

        $accion = $nuevoEstado ? 'bloqueado' : 'desbloqueado';
        return response()->json(['message' => "Usuario {$accion} con éxito"]);
    }
}
