<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PasswordOtp;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                'min:8',      
                'confirmed',
                'regex:/[A-Z]/',
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
            'password' => $request->password,
            'phone' => $request->phone,
            'role' => 'customer',
        ]);

        try {
            $user->sendEmailVerificationNotification();
        } catch (\Throwable $e) {
        }

        return redirect('/login')->with('success', 'Pendaftaran berhasil! Silakan cek email untuk verifikasi.');
    }
    
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

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
            // if ($existing) {
            //     Auth::login($existing, true);
            //     return redirect('/');
            // }
            if ($existing) {
                if (! $existing->email_verified_at) {
                    $existing->update([
                        'email_verified_at' => now()
                    ]);
                }
            
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

    // public function completeRegister(Request $request)
    // {
    //     $email = session('google_email');
    //     if (! $email) {
    //         return redirect()->route('login');
    //     }

    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'phone' => 'required|string|max:20',
    //     ]);

    //     $user = User::firstOrCreate(
    //         ['email' => $email],
    //         [
    //             'name' => $request->name,
    //             'password' => Str::random(40),
    //             'phone' => $request->phone,
    //             'role' => 'customer',
    //         ]
    //     );

    //     session()->forget(['google_email', 'google_name']);
    //     Auth::login($user, true);

    //     return redirect('/');
    // }
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

        $user = User::where('email', $email)->first();

        if (! $user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $email,
                'password' => Hash::make(Str::random(40)),
                'phone' => $request->phone,
                'role' => 'customer',
                'email_verified_at' => now(), // 🔥 PENTING
            ]);
        } else {
            // kalau user sudah ada, pastikan datanya lengkap
            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
            ]);
        }

        session()->forget(['google_email', 'google_name']);
        Auth::login($user, true);

        return redirect('/');
    }

    public function forgotPasswordForm()
    {
        return view('auth.forgot-password');
    }


    public function sendOtp(Request $request)
    {
        $user = auth()->user();
    
        $otp = rand(100000, 999999);
    
        DB::table('password_otps')->updateOrInsert(
            ['email' => $user->email],
            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(5),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    
        Mail::to($user->email)->send(new OtpMail($otp));
    
        // SIMPAN EMAIL KE SESSION
        session(['email' => $user->email]);
    
        // PINDAH KE HALAMAN INPUT OTP
        return redirect()->route('otp.form')
            ->with('success', 'Kode OTP telah dikirim ke email Anda');
    }
    

    public function verifyOtpForm()
    {
        if (!session('otp_email')) {
            return redirect()->route('password.forgot');
        }

        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);
    
        $record = PasswordOtp::where('email', session('otp_email'))
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();
    
        if (! $record) {
            return back()->with('error', 'OTP salah atau kadaluarsa');
        }
    
        $record->delete();
        session(['otp_verified' => true]);
    
        return redirect()->route('password.new');
    }
    
    public function newPasswordForm()
    {
        if (! session('otp_verified')) {
            abort(403);
        }
    
        return view('auth.new-password');
    }

    public function saveNewPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed'
        ]);
    
        $email = session('otp_email');
    
        User::where('email', $email)->update([
            'password' => Hash::make($request->password)
        ]);
    
        session()->forget(['otp_email', 'otp_verified']);
    
        return redirect('/login')->with('success', 'Password berhasil diubah');
    }
        
}