<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();


            if ($user->role === 'admin') {
                return redirect('/admin');
            }

            return redirect('/');
        }

        return back()->with('error', 'Email atau password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',          // minimal 8 karakter
                'confirmed',
                'regex:/[A-Z]/',  // minimal 1 huruf kapital
            ],
            'phone' => 'required|string|max:20',
        ], [
            'password.min' => 'Password minimal 8 karakter.',
            'password.regex' => 'Password harus mengandung minimal 1 huruf kapital.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            // Use Laravel's hashed cast on the User model
            'password' => $request->password,
            'phone' => $request->phone,
            'role' => 'customer',
        ]);

        // kirim email verifikasi (jangan blokir jika mail tidak terkonfigurasi)
        try {
            $user->sendEmailVerificationNotification();
        } catch (\Throwable $e) {
            // optional: log error
        }

        return redirect('/login')->with('success', 'Pendaftaran berhasil! Silakan cek email untuk verifikasi.');
    }
    
        // Tampilkan form lupa password
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // Kirim email reset password
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Password berhasil direset!')
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $existing = User::where('email', $googleUser->getEmail())->first();
            if ($existing) {
                Auth::login($existing, true);
                return redirect('/');
            }

            session([
                'google_email' => $googleUser->getEmail(),
                'google_name' => $googleUser->getName(),
            ]);

            return redirect()->route('register.complete');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Login Google gagal!');
        }
    }

    public function showCompleteRegisterForm()
    {
        if (! session()->has('google_email')) {
            return redirect()->route('login');
        }

        return view('auth.complete-register', [
            'email' => session('google_email'),
            'name' => session('google_name'),
        ]);
    }

    public function completeRegister(Request $request)
    {
        $email = session('google_email');
        if (! $email) {
            return redirect()->route('login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $request->name,
                // Generate a secure random password internally; user doesn't need to set it now
                'password' => Str::random(40),
                'phone' => $request->phone,
                'role' => 'customer',
            ]
        );

        session()->forget(['google_email', 'google_name']);
        Auth::login($user, true);

        return redirect('/');
    }

}
