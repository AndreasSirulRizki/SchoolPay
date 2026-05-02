<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureSiswaAuth
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (!auth('siswa')->check()) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
