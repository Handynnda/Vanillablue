<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FilamentAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        $guard = Auth::guard('web');

        if (! $guard->check()) {
            return redirect()->guest(route('login', ['redirect' => $request->fullUrl()]));
        }

        $user = $guard->user();

        $isAdmin = false;

        if (isset($user->role) && Str::lower($user->role) === 'admin') {
            $isAdmin = true;
        }

        if (! $isAdmin) {
            $admins = config('filament_admins') ?? env('FILAMENT_ADMINS', '');
            $list = array_filter(array_map('trim', explode(',', $admins)));
            if (in_array($user->email, $list, true)) {
                $isAdmin = true;
            }
        }

        if (! $isAdmin) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}
