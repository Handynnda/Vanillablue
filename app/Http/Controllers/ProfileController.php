<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;




class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.profile', compact('user'));
    }

    // 1. KIRIM OTP KE EMAIL
    public function sendOtp()
    {
        $otp = rand(100000, 999999);
        session(['otp_code' => $otp]);

        // Contoh email — bisa kamu sesuaikan
        Mail::raw("Kode OTP Anda adalah: " . $otp, function ($message) {
            $message->to(Auth::user()->email)
                    ->subject("Kode OTP Verifikasi");
        });

        return redirect()->route('profile.otp.page')
                         ->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    // 2. TAMPILKAN HALAMAN VERIFIKASI OTP + GANTI PASSWORD
    public function verifyOtpPage()
    {
        return view('profile.verifikasi');
    }

    // 3. UPDATE PASSWORD
    public function updatePassword(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($request->otp != session('otp_code')) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid.']);
        }

        // Update password user
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus OTP dari session
        session()->forget('otp_code');

        return redirect()->route('profile.index')
                         ->with('success', 'Password berhasil diperbarui.');
    }
}
