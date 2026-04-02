<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Verifica se o usuário autenticado possui a permissão informada.
     *
     * Uso nas rotas:
     *   ->middleware('permission:usuarios.visualizar')
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (! $request->user()) {
            abort(Response::HTTP_UNAUTHORIZED, 'Não autenticado.');
        }

        if (! $request->user()->hasPermission($permission)) {
            abort(Response::HTTP_FORBIDDEN, 'Permissão insuficiente.');
        }

        return $next($request);
    }
}
