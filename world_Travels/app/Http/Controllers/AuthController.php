<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Usuarios;
use App\Models\Empresa;
use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function registrar(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'Nombre' => 'sometimes|required|string|max:255',
            'Apellido' => 'sometimes|required|string|max:255',
            'Email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'Telefono' => 'sometimes|required|string|max:20',
            'Nacionalidad' => 'sometimes|required|string|max:255',
            'roles' => 'required|string|in:usuario,empresa,administrador',
            'NombreEmpresa' => 'sometimes|required|string|max:255',
            'NitEmpresa' => 'sometimes|required|string|max:255',
            'DireccionEmpresa' => 'sometimes|required|string|max:255',
            'CiudadEmpresa' => 'sometimes|required|string|max:255'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        // Crear usuario base
        $user = User::create([
            'name' => $request->Nombre ? $request->Nombre . ' ' . $request->Apellido : $request->NombreEmpresa,
            'email' => $request->Email,
            'password' => Hash::make($request->password),
            'role' => $request->roles,
            'nit' => $request->roles === 'empresa' ? $request->NitEmpresa : null,
            'direccion' => $request->roles === 'empresa' ? $request->DireccionEmpresa : null,
            'ciudad' => $request->roles === 'empresa' ? $request->CiudadEmpresa : null,
        ]);

        $userId = $user->id;

        // Crear registro específico según el rol
        if ($request->roles === 'usuario') {
            Usuarios::create([
                'Nombre' => $request->Nombre,
                'Apellido' => $request->Apellido,
                'Email' => $request->Email,
                'Contraseña' => Hash::make($request->password),
                'Telefono' => $request->Telefono,
                'Nacionalidad' => $request->Nacionalidad,
                'Fecha_Registro' => now(),
            ]);
        } elseif ($request->roles === 'empresa') {
            Empresa::create([
                'nombre' => $request->NombreEmpresa,
                'nit' => $request->NitEmpresa,
                'direccion' => $request->DireccionEmpresa,
                'ciudad' => $request->CiudadEmpresa,
                'email' => $request->Email,
                'contraseña' => Hash::make($request->password),
            ]);
        } elseif ($request->roles === 'administrador') {
            Administrador::create([
                'nombre' => $request->Nombre,
                'apellido' => $request->Apellido,
                'telefono' => $request->Telefono,
                'correo' => $request->Email,
                'documento' => $request->Email,
                'contraseña' => Hash::make($request->password),
            ]);
        }

        try{
            $token = JWTAuth::fromUser($user);
            return response()->json([
                'success' => true,
                'user' => $user,
                'token' => $token,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo crear el Token JWT',
                'error' => $e->getMessage(),
            ], 500);
        }
    } 

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $credentials = $request->only('email', 'password');
        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json([
               'success' => false,
                 'message' => 'Credenciales inválidas',
            ], 401);
        }

        $user = JWTAuth::user();

        if ($user->is_blocked) {
            return response()->json([
                'success' => false,
                'message' => 'Tu cuenta ha sido bloqueada. Contacta al administrador.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    }

    public function logout(){
        try{
            $usuarios = JWTAuth::user(); // validar el usuario logeado
            JWTAuth::invalidate(JWTAuth::getToken()); // invalidar el token
            return response()->json([
                'success' => true,
                'message' => $usuarios->Nombre.' ha cerrado sesión correctamente',
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error al cerrar la sesión',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function me ()
    {
        return response()->json([
            'success' => true,
            'usuario' => JWTAuth::user(),
        ], 200);
    }
    


}