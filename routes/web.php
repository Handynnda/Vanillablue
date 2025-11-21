<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\BundlingController;
use App\Http\Controllers\GalleryController;

Route::get('/', function () {return view('home');});
Route::get('/home',function(){return view('home');});
Route::get('/contact',function(){return view('contact');});
Route::get('/footer',function(){return view('footer');});
Route::get('/header',function(){return view('header');});

// Tampilan galeri tunggal — konten diisi dinamis oleh GalleryController
Route::get('/galeri/detail', [GalleryController::class, 'index'])->name('galeri.detail');
// Legacy routes kept for compatibility; redirect to single dynamic view with category
Route::get('/galeri/baby', function () { return redirect()->route('galeri.detail', ['category' => 'baby']); });
Route::get('/galeri/birthday', function () { return redirect()->route('galeri.detail', ['category' => 'birthday']); });
Route::get('/galeri/couple', function () { return redirect()->route('galeri.detail', ['category' => 'couple']); });
Route::get('/galeri/family', function () { return redirect()->route('galeri.detail', ['category' => 'family']); });
Route::get('/galeri/graduation', function () { return redirect()->route('galeri.detail', ['category' => 'graduation']); });
Route::get('/galeri/prewed', function () { return redirect()->route('galeri.detail', ['category' => 'prewed']); });


Route::get('/listharga', [BundlingController::class, 'index'])->name('listharga');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::get('/booking/{id}', [BookingController::class, 'index'])->name('booking');

Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// route untuk verifikasi email
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/booking', [BookingController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('booking');

// route untuk kirim ulang link verifikasi
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Link verifikasi sudah dikirim!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');