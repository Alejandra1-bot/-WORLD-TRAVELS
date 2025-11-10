<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $empresas = Empresa::all();
            return response()->json([
                'success' => true,
                'data' => $empresas,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener empresas',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Empresa::rules());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $data = $request->all();
            $data['contraseña'] = Hash::make($request->contraseña);

            $empresa = Empresa::create($data);

            return response()->json([
                'success' => true,
                'data' => $empresa,
                'message' => 'Empresa creada exitosamente',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear empresa',
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
            $empresa = Empresa::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $empresa,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Empresa no encontrada',
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
            $empresa = Empresa::findOrFail($id);

            $validator = Validator::make($request->all(), Empresa::rules($id));

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

            $empresa->update($data);

            return response()->json([
                'success' => true,
                'data' => $empresa,
                'message' => 'Empresa actualizada exitosamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar empresa',
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
            $empresa = Empresa::findOrFail($id);
            $empresa->delete();

            return response()->json([
                'success' => true,
                'message' => 'Empresa eliminada exitosamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar empresa',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Login para empresas
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'correo' => 'required|string|email',
            'contraseña' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $credentials = $request->only('correo', 'contraseña');

        try {
            if (!$token = JWTAuth::attempt($credentials, ['provider' => 'empresas'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Credenciales inválidas',
                ], 401);
            }

            return response()->json([
                'success' => true,
                'token' => $token,
                'empresa' => JWTAuth::user(),
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
     * Logout para empresas
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
     * Obtener información de la empresa autenticada
     */
    public function me()
    {
        try {
            return response()->json([
                'success' => true,
                'empresa' => JWTAuth::user(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener información de la empresa',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
