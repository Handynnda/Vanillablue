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
        // Use the web guard (the application's normal login)
        $guard = Auth::guard('web');

        if (! $guard->check()) {
            // Not logged in: redirect to the application's login page
            return redirect()->guest(route('login', ['redirect' => $request->fullUrl()]));
        }

        $user = $guard->user();

        // Authorization check:
        // 1) If user has a `role` attribute and it's `admin`, allow.
        // 2) Otherwise, allow if user's email is in FILAMENT_ADMINS env list (comma separated).
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
            abort(403, 'Anda tidak memiliki akses ke panel admin.');
        }

        return $next($request);
    }
}
