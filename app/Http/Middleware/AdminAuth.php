<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Sync session login with Laravel Auth guard so auth()->user() works
        if (!auth()->check() && session('admin_user_id')) {
            \Illuminate\Support\Facades\Auth::loginUsingId(session('admin_user_id'));
        }

        return $next($request);
    }
}
