<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\BundlingController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PaymentController;
<<<<<<< HEAD
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
=======
use Illuminate\Support\Facades\Auth;
>>>>>>> 28853b44cb56702190d42310540c3ea2aa073b21

Route::get('/', function () {return view('home');});
Route::get('/home',function(){return view('home');});
Route::get('/contact',function(){return view('contact');});
Route::get('/footer',function(){return view('footer');});
Route::get('/header',function(){return view('header');});

Route::get('/update', [OrderController::class, 'index'])->name('orders.index');

Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');

Route::get('/galeri/detail', [GalleryController::class, 'index'])->name('galeri.detail');
Route::get('/galeri/baby', function () { return redirect()->route('galeri.detail', ['category' => 'baby']); });
Route::get('/galeri/birthday', function () { return redirect()->route('galeri.detail', ['category' => 'birthday']); });
Route::get('/galeri/couple', function () { return redirect()->route('galeri.detail', ['category' => 'couple']); });
Route::get('/galeri/family', function () { return redirect()->route('galeri.detail', ['category' => 'family']); });
Route::get('/galeri/graduation', function () { return redirect()->route('galeri.detail', ['category' => 'graduation']); });
Route::get('/galeri/prewed', function () { return redirect()->route('galeri.detail', ['category' => 'prewed']); });


Route::get('/listharga', [BundlingController::class, 'index'])->name('listharga');
Route::get('/galeri/{id}', [BundlingController::class, 'show'])->name('galeri.show');

Route::middleware(['auth'])->group(function() {

    // PROFILE MAIN PAGE
    Route::get('/profile', [ProfileController::class, 'index'])
         ->name('profile.index');

    // KIRIM OTP
    Route::post('/profile/send-otp', [ProfileController::class, 'sendOtp'])
         ->name('profile.otp.send');

    // HALAMAN VERIFIKASI OTP
    Route::get('/profile/verify', [ProfileController::class, 'verifyOtpPage'])
         ->name('profile.otp.page');

    // UPDATE PASSWORD
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])
         ->name('profile.otp.update');
});


// AUTH 
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');

// BOOKING (pakai ID paket)
Route::get('/booking/{id}', [BookingController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('booking');
Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');

// PAYMENT
Route::get('/payment/{order}', [PaymentController::class, 'create'])->middleware(['auth','verified'])->name('payment.create');
Route::post('/payment', [PaymentController::class, 'store'])->middleware(['auth','verified'])->name('payment.store');

// AUTH POST
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Complete Register after Google
Route::get('/register/complete', [AuthController::class, 'showCompleteRegisterForm'])->name('register.complete');
Route::post('/register/complete', [AuthController::class, 'completeRegister'])->name('register.complete.post');

// EMAIL VERIFICATION
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

// KIRIM ULANG VERIFIKASI EMAIL
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Link verifikasi sudah dikirim!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//route login google
Route::get('/login/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [AuthController::class, 'handleGoogleCallback']);

//logout admin
Route::post('/logout', function () {
    Auth::logout();

    return redirect('/');
})->name('logout');