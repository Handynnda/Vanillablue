<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BundlingController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {return view('home');});
Route::get('/home',function(){return view('home');});
Route::get('/contact',function(){return view('contact');});
Route::get('/footer',function(){return view('footer');});
Route::get('/header',function(){return view('header');});

Route::get('/update', [OrderController::class, 'index'])
    ->name('orders.index');
Route::post('/profile/update', [ProfileController::class, 'update'])
    ->name('profile.update');
Route::get('/orders', [OrderController::class, 'index'])
    ->name('orders.index');
Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])
    ->name('orders.update-status');
Route::get('/galeri/detail', [GalleryController::class, 'index'])
    ->name('galeri.detail');
Route::get('/galeri/baby', function () { return redirect()
    ->route('galeri.detail', ['category' => 'baby']); });
Route::get('/galeri/birthday', function () { return redirect()
    ->route('galeri.detail', ['category' => 'birthday']); });
Route::get('/galeri/couple', function () { return redirect()
    ->route('galeri.detail', ['category' => 'couple']); });
Route::get('/galeri/family', function () { return redirect()
    ->route('galeri.detail', ['category' => 'family']); });
Route::get('/galeri/graduation', function () { return redirect()
    ->route('galeri.detail', ['category' => 'graduation']); });
Route::get('/galeri/prewed', function () { return redirect()
    ->route('galeri.detail', ['category' => 'prewed']); });


Route::get('/listharga', [BundlingController::class, 'index'])
    ->name('listharga');
Route::get('/galeri/{id}', [BundlingController::class, 'show'])
    ->name('galeri.show');
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::post('/profile/send-otp', [AuthController::class, 'sendOtpFromProfile'])
        ->name('profile.sendOtp');
});


// AUTH 
Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])
    ->name('register');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])
    ->name('password.reset');
Route::get('/new-password', [AuthController::class, 'newPasswordForm'])
    ->name('password.new');
Route::get('/forgot-password', [AuthController::class, 'forgotPasswordForm'])
    ->name('password.forgot')
    ->middleware('guest');
Route::post('/forgot-password', [AuthController::class, 'sendOtpForgotPassword'])
    ->name('password.forgot.send')
    ->middleware('guest');
Route::get('/verify-otp', [AuthController::class, 'verifyOtpForm'])
    ->name('otp.form')
    ->middleware('guest');   
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])
    ->name('otp.verify')
    ->middleware('auth');
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])
    ->name('otp.resend');
Route::post('/new-password', [AuthController::class, 'saveNewPassword']);

// BOOKING (pakai ID paket)
// Bungkus dalam group agar konsisten
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/booking/{id}', [BookingController::class, 'index'])->name('booking');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
});

// PAYMENT
Route::get('/payment/{order}', [PaymentController::class, 'create'])
    ->middleware(['auth','verified'])->name('payment.create');
Route::post('/payment', [PaymentController::class, 'store'])
    ->middleware(['auth','verified'])->name('payment.store');

// AUTH POST
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])
    ->name('password.update');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Complete Register after Google
Route::get('/register/complete', [AuthController::class, 'showCompleteRegisterForm'])
    ->name('register.complete');
Route::post('/register/complete', [AuthController::class, 'completeRegister'])
    ->name('register.complete.post');

// EMAIL VERIFICATION
Route::get('/email/verify', function () {return view('auth.verify-email');})
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', 
function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');})
        ->middleware(['auth', 'signed'])
        ->name('verification.verify');

// KIRIM ULANG VERIFIKASI EMAIL
Route::post('/email/verification-notification', 
function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Link verifikasi sudah dikirim!');})
        ->middleware(['auth', 'throttle:6,1'])
        ->name('verification.send');

//route login google
Route::get('/login/google', [AuthController::class, 'redirectToGoogle'])
    ->name('login.google');
Route::get('/login/google/callback', [AuthController::class, 'handleGoogleCallback']);

//logout admin
Route::post('/logout', function () {Auth::logout();return redirect('/');})
    ->name('logout');

    Route::get('/cetak-order', [OrderController::class, 'printOrder'])->name('print.order');
Route::get('/cetak-payment', [PaymentController::class, 'printPayment'])->name('print.payment');