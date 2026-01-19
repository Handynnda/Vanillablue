<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Mail\OtpMail;
use App\Models\User;
use App\Models\PasswordOtp;
use Illuminate\Support\Facades\DB;
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

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        $link = url('/reset-password/'.$token.'?email='.$request->email);

        Mail::raw(
            "Klik link berikut untuk reset password:\n\n$link",
            fn ($message) => $message
                ->to($request->email)
                ->subject('Reset Password')
        );

        return back()->with('success', 'Link reset password telah dikirim ke email.');
    }
    
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function resetPasswordForm()
    {
        if (!session('otp_verified')) {
            return redirect()->route('login');
        }

        return view('auth.reset-password');
    }
    
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function showResetPasswordForm()
    {
        if (! session()->has('otp_verified')) {
            return redirect()->route('password.otp.form')           
            ->withErrors('Silakan verifikasi OTP terlebih dahulu.');
        }

        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required',
        ]);

        $record = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (! $record || ! Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'Token reset tidak valid.']);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect('/login')->with('success', 'Password berhasil diubah.');
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
                'email_verified_at' => now(),
            ]);
        } else {
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

    public function sendOtpForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = rand(100000, 999999);

        session([
            'otp_email' => $request->email,
            'otp_context' => 'forgot',
        ]);

        Mail::to($request->email)->send(new OtpMail($otp));

        return redirect()->route('password.otp.form')
            ->with('success', 'Kode OTP telah dikirim ke email.');
    }

    public function sendOtpFromForgot(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = rand(100000, 999999);

        PasswordOtp::updateOrCreate(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(5),
            ]
        );

        Mail::to($request->email)->send(new OtpMail($otp));

        session([
            'otp_email' => $request->email,
            'otp_context' => 'forgot',
        ]);

        return redirect()->route('password.otp.form')
            ->with('success', 'Kode OTP telah dikirim ke email.');
        }

    public function sendOtpFromProfile()
    {
        $user = Auth::user();

        $otp = rand(100000, 999999);

        PasswordOtp::updateOrCreate(
            ['email' => $user->email],
            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(5),
            ]
        );
        

        Mail::to($user->email)->send(new OtpMail($otp));

        session([
            'otp_email' => $user->email,
            'otp_context' => 'profile',
        ]);

        return redirect()->route('profile.otp.form');
    }

    public function resendOtp(Request $request)
    {
        $email = session('otp_email');

        if (!$email) {
            return redirect()->route('password.request')
                ->withErrors('Session OTP tidak ditemukan, silakan ulangi.');
        }

        $otp = rand(100000, 999999);

        PasswordOtp::updateOrCreate(
            ['email' => $email],
            [
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(5),
            ]
        );

        Mail::to($email)->send(new OtpMail($otp));

        return back()->with('success', 'Kode OTP baru telah dikirim.');
    }

    public function verifyOtpForm()
    {
        if (!session('otp_email')) {
            return redirect()->route('password.forgot');
        }

        return view('auth.verify-otp');
    }

    public function verifyOtpProfileForm()
    {
        return view('auth.verify-otp');
    }

    public function verifyOtpProfile(Request $request)
    {

        if (session('otp_context') !== 'profile') {
        abort(403);
        }
        
        $request->validate([
            'otp' => 'required'
        ]);

        $email = session('otp_email');

        if (! $email || session('otp_context') !== 'profile') {
            return redirect()->route('profile.index');
        }

        $record = PasswordOtp::where('email', $email)->first();

        if (
            ! $record ||
            $record->otp != $request->otp ||
            now()->gt($record->expires_at)
        ) {
            return back()->withErrors([
                'otp' => 'Kode OTP tidak valid atau kadaluarsa'
            ]);
        }

        session([
            'otp_verified' => true,
            'email' => $email,
        ]);

        $record->delete();

        return redirect()->route('profile.password.form');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $email = session('otp_email');

        if (! $email) {
            return redirect()->route('password.forgot')
                ->withErrors('Session OTP tidak ditemukan.');
        }

        $record = PasswordOtp::where('email', $email)->first();

        if (
            ! $record ||
            $record->otp != $request->otp ||
            now()->gt($record->expires_at)
        ) {
            return back()->withErrors([
                'otp' => 'Kode OTP tidak valid atau kadaluarsa'
            ]);
        }

        // OTP VALID → SIMPAN SEMUA YANG DIBUTUHKAN
        session([
            'otp_verified' => true,
            'email' => $email
        ]);

        $record->delete();

        return redirect()->route('password.new');
    }

    public function newPasswordForm()
    {
        if (! session('otp_verified') || ! session('email')) {
            return redirect()->route('password.forgot');
        }

        return view('auth.reset-password');
    }

    public function saveNewPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed'
        ]);
    
        $email = session('email');

        if (! $email) {
            return redirect()->route('password.forgot')
                ->withErrors('Session email tidak ditemukan.');
        }
    
        User::where('email', $email)->update([
            'password' => Hash::make($request->password)
        ]);
    
        session()->forget(['otp_email', 'otp_verified', 'email']);
    
        return redirect('/login')->with('success', 'Password berhasil diubah');
    }
        
}
