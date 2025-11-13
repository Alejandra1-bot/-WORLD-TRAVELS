<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\DepartamentosController;
use App\Http\Controllers\MunicipiosController;
use App\Http\Controllers\Categorias_ActividadesController;
use App\Http\Controllers\ActividadesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\ComentariosController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\EmpresaController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Container\Attributes\Auth;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

    // Route::middleware('jwt.auth')->group(function (){});

    Route::post('registrar', [AuthController::class, 'registrar']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('enviar-codigo-verificacion', [AuthController::class, 'enviarCodigoVerificacion']);

    // Rutas para Administradores
    Route::post('administradores/login', [AdministradorController::class, 'login']);
    Route::post('administradores/registrar', [AdministradorController::class, 'store']);

    // Rutas para Empresas
    Route::post('empresas/login', [EmpresaController::class, 'login']);
    Route::post('empresas/registrar', [EmpresaController::class, 'store']);

    Route::group(['middleware' => [JwtMiddleware::class]], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });

    Route::group(['middleware' => [JwtMiddleware::class . ':Administrador']], function () {
    Route::post('crearDepartamentos', [DepartamentosController::class, 'store']);
    Route::get('departamentos/{id}', [DepartamentosController::class, 'show']);
    Route::put('actualizarDepartamentos/{id}', [DepartamentosController::class, 'update']);
    Route::delete('eliminarDepartamentos/{id}', [DepartamentosController::class, 'destroy']);
    Route::post('crearMunicipios', [MunicipiosController::class, 'store']);
    Route::get('municipios/{id}', [MunicipiosController::class, 'show']);
    Route::put('actualizarMunicipios/{id}', [MunicipiosController::class, 'update']);
    Route::delete('eliminarMunicipios/{id}', [MunicipiosController::class, 'destroy']);
    Route::post('crearCategorias', [Categorias_ActividadesController::class, 'store']);
    Route::get('categorias/{id}', [Categorias_ActividadesController::class, 'show']);
    Route::put('actualizarCategorias/{id}', [Categorias_ActividadesController::class, 'update']);
    Route::delete('eliminarCategorias/{id}', [Categorias_ActividadesController::class, 'destroy']);
    Route::post('crearActividades', [ActividadesController::class, 'store']);
    Route::get('actividades/{id}', [ActividadesController::class, 'show']);
    Route::put('actualizarActividades/{id}', [ActividadesController::class, 'update']);
    Route::delete('eliminarActividades/{id}', [ActividadesController::class, 'destroy']);
    Route::get('listarReservas', [ReservasController::class, 'index']);
    Route::put('actualizarComentarios/{id}', [ComentariosController::class, 'update']);
    Route::put('bloquearUsuarios/{id}', [UsuariosController::class, 'bloquear']);

    });


// Rutas para Usuarios
Route::get('listarUsuarios', [UsuariosController::class, 'index']);
Route::post('crearUsuarios', [UsuariosController::class, 'store']);
Route::get('usuarios/{id}', [UsuariosController::class, 'show']);
Route::put('actualizarUsuarios/{id}', [UsuariosController::class, 'update']);
Route::delete('eliminarUsuarios/{id}', [UsuariosController::class, 'destroy']);

 // Rutas para Departamentos
Route::get('listarDepartamentos', [DepartamentosController::class, 'index']);
// Route::post('crearDepartamentos', [DepartamentosController::class, 'store']);
// Route::get('departamentos/{id}', [DepartamentosController::class, 'show']);
// Route::put('actualizarDepartamentos/{id}', [DepartamentosController::class, 'update']);
// Route::delete('eliminarDepartamentos/{id}', [DepartamentosController::class, 'destroy']);

// Rutas para Municipios
Route::get('listarMunicipios', [MunicipiosController::class, 'index']);
// Route::post('crearMunicipios', [MunicipiosController::class, 'store']);
// Route::get('municipios/{id}', [MunicipiosController::class, 'show']);
// Route::put('actualizarMunicipios/{id}', [MunicipiosController::class, 'update']);
// Route::delete('eliminarMunicipios/{id}', [MunicipiosController::class, 'destroy']);

// Rutas para Categorías de Actividades
Route::get('listarCategorias', [Categorias_ActividadesController::class, 'index']);
// Route::post('crearCategorias', [Categorias_ActividadesController::class, 'store']);
// Route::get('categorias/{id}', [Categorias_ActividadesController::class, 'show']);
// Route::put('actualizarCategorias/{id}', [Categorias_ActividadesController::class, 'update']);
// Route::delete('eliminarCategorias/{id}', [Categorias_ActividadesController::class, 'destroy']);
// Rutas para Actividades
Route::get('listarActividades', [ActividadesController::class, 'index']);
Route::get('actividades', [ActividadesController::class, 'index']);
// Route::post('crearActividades', [ActividadesController::class, 'store']);
// Route::get('actividades/{id}', [ActividadesController::class, 'show']);
// Route::put('actualizarActividades/{id}', [ActividadesController::class, 'update']);
// Route::delete('eliminarActividades/{id}', [ActividadesController::class, 'destroy']);

// Rutas para Reservas
// Route::get('listarReservas', [ReservasController::class, 'index']);
Route::post('crearReservas', [ReservasController::class, 'store']);
Route::get('reservas/{id}', [ReservasController::class, 'show']);
Route::put('actualizarReservas/{id}', [ReservasController::class, 'update']);
Route::delete('eliminarReservas/{id}', [ReservasController::class, 'destroy']);

// Rutas para Comentarios
Route::get('listarComentarios', [ComentariosController::class, 'index']);
Route::post('crearComentarios', [ComentariosController::class, 'store']);
Route::get('comentarios/{id}', [ComentariosController::class, 'show']);
Route::put('actualizarComentarios/{id}', [ComentariosController::class, 'update']);
Route::delete('eliminarComentarios/{id}', [ComentariosController::class, 'destroy']);
