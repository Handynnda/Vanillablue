<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
        ]);
    
        $user = User::find(Auth::id());
    
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
    
        return back()->with('success', 'Profil berhasil diperbarui');
    }
    

    public function sendOtp()
    {
        $user = Auth::user();
        $otp = rand(100000, 999999);

        // simpan OTP 5 menit
        Cache::put('otp_'.$user->id, $otp, now()->addMinutes(5));

        Mail::raw(
            "Kode OTP Anda: $otp\nBerlaku selama 5 menit.",
            function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Kode OTP Perubahan Password');
            }
        );

        return back()->with('success', 'Kode OTP berhasil dikirim ke email Anda');
    }
}
