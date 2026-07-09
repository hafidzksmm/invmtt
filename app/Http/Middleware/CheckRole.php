<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * Contoh pemakaian di route:
     *   ->middleware('role:admin,superadmin')  // admin & superadmin boleh lewat
     *   ->middleware('role:superadmin')        // hanya superadmin
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk melakukan operasi ini.');
        }

        return $next($request);
    }
}
