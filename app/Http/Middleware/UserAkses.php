<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // 
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $userRole = auth()->user()->role;

        foreach ($roles as $role) {
            if ($userRole == $role) {
                return $next($request);
            }
        }
        $user = Auth::user();
        if ($user->role == 'admin' || $user->role == 'pegawai') {
            return redirect('/admin');
            // return response()->json(['message' => 'Hei Ini bukan menu untuk anda Dasar Pegawai.']);
        } elseif ($user->role == 'tamu') {
            return redirect('/');
            // return response()->json(['message' => 'Hei Ini bukan menu untuk anda Dasar Tamu.']);
        } else {
            return 'Anda Siapa?';
        }
        
    }
}
