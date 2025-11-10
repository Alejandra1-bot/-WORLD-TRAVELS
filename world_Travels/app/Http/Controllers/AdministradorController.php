<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdministradorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $administradores = Administrador::all();
            return response()->json([
                'success' => true,
                'data' => $administradores,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener administradores',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Administrador::rules());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $data = $request->all();
            $data['contraseña'] = Hash::make($request->contraseña);

            $administrador = Administrador::create($data);

            return response()->json([
                'success' => true,
                'data' => $administrador,
                'message' => 'Administrador creado exitosamente',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear administrador',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $administrador = Administrador::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $administrador,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Administrador no encontrado',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $administrador = Administrador::findOrFail($id);

            $validator = Validator::make($request->all(), Administrador::rules($id));

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->all();
            if ($request->has('contraseña') && !empty($request->contraseña)) {
                $data['contraseña'] = Hash::make($request->contraseña);
            } else {
                unset($data['contraseña']);
            }

            $administrador->update($data);

            return response()->json([
                'success' => true,
                'data' => $administrador,
                'message' => 'Administrador actualizado exitosamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar administrador',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $administrador = Administrador::findOrFail($id);
            $administrador->delete();

            return response()->json([
                'success' => true,
                'message' => 'Administrador eliminado exitosamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar administrador',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Login para administradores
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'correo_electronico' => 'required|string|email',
            'contraseña' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $credentials = $request->only('correo_electronico', 'contraseña');

        try {
            if (!$token = JWTAuth::attempt($credentials, ['provider' => 'administradores'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Credenciales inválidas',
                ], 401);
            }

            return response()->json([
                'success' => true,
                'token' => $token,
                'administrador' => JWTAuth::user(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en la autenticación',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Logout para administradores
     */
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'success' => true,
                'message' => 'Sesión cerrada exitosamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cerrar sesión',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtener información del administrador autenticado
     */
    public function me()
    {
        try {
            return response()->json([
                'success' => true,
                'administrador' => JWTAuth::user(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener información del administrador',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
