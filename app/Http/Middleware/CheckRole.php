<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Verifica se o usuário autenticado possui um dos roles permitidos.
     *
     * Uso nas rotas:
     *   ->middleware('role:administrador')
     *   ->middleware('role:administrador,gestor')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            abort(Response::HTTP_UNAUTHORIZED, 'Não autenticado.');
        }

        $slugs = array_map(fn ($r) => strtolower(trim($r)), $roles);

        if (! $request->user()->hasAnyRole($slugs)) {
            abort(Response::HTTP_FORBIDDEN, 'Acesso não autorizado.');
        }

        return $next($request);
    }
}
