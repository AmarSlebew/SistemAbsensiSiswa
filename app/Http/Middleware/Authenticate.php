<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Jika akses /admin tapi belum login → ke /admin/login (Filament)
        if ($request->is('admin*')) {
            return route('filament.admin.auth.login');
        }

        // Kalau akses selain itu → ke /login (Breeze)
        return route('login');
    }
}
