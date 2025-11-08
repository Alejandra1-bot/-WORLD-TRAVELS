<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles = null): Response
    {
        try{
            $usuario = JWTAuth::parseToken()->authenticate(); // para saber si esta autenticado el usuario
        }catch(\Exception $e){
            // si no hay token valido o esta vencido, devolvemos error
            return response()->json(['error' => 'Token inválido o expirado'], 401);
        }

        if ($roles && $usuario->Rol !== $roles) {
            return response()->json(['error' => 'Acceso denegado. No tienes el rol necesario'], 403);
        }

        return $next($request); //  para que continue con la peticion
    }

}