<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $isAdmin = $user && in_array($user->role, ['admin_sekolah', 'admin_dudi'], true);
        abort_unless($isAdmin, 403);
        return $next($request);
    }
}


