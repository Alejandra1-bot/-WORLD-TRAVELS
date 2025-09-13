<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\DepartamentosController;
use App\Http\Controllers\MunicipiosController;
use App\Http\Controllers\CategoriasActividadesController;
use App\Http\Controllers\ActividadesController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\ComentariosController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas para Usuarios
Route::get('listarUsuarios', [UsuariosController::class, 'index']);
Route::post('crearUsuarios', [UsuariosController::class, 'store']);
Route::get('usuarios/{id}', [UsuariosController::class, 'show']);
Route::put('actualizarUsuarios/{id}', [UsuariosController::class, 'update']);
Route::delete('eliminarUsuarios/{id}', [UsuariosController::class, 'destroy']);

 // Rutas para Departamentos
Route::get('listarDepartamentos', [DepartamentosController::class, 'index']);
Route::post('crearDepartamentos', [DepartamentosController::class, 'store']);
Route::get('departamentos/{id}', [DepartamentosController::class, 'show']);
Route::put('actualizarDepartamentos/{id}', [DepartamentosController::class, 'update']);
Route::delete('eliminarDepartamentos/{id}', [DepartamentosController::class, 'destroy']);
