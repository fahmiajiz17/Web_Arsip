<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRoleId = Auth::user()->role;

        if (!in_array($userRoleId, $roles)) {
            abort(404, 'Kamu tidak memiliki akses.');
        }

        return $next($request);
    }
}