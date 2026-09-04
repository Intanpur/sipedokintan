<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // User belum login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil user yang sedang login
        $user = Auth::user();

        // Pastikan user mempunyai role
        if (!$user || !$user->role) {
            Auth::logout();

            return redirect()->route('login')
                ->withErrors([
                    'email' => 'Role pengguna belum tersedia.'
                ]);
        }

        // Cek role
        if (!in_array($user->role, $roles, true)) {
            abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
        }

        return $next($request);
    }
}
