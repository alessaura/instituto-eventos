<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFilamentPermissions
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = auth()->user();

        if (!$user) {
            abort(401, 'Não autenticado');
        }

        $hasPermission = match ($permission) {
            'admin' => $user->isAdmin(),
            'edit' => $user->podeEditar(),
            'delete' => $user->podeExcluir(),
            'manage-users' => $user->podeGerenciarUsuarios(),
            default => false,
        };

        if (!$hasPermission) {
            abort(403, 'Sem permissão para esta ação');
        }

        return $next($request);
    }
}