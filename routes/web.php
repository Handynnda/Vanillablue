<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BundlingController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| HALAMAN UMUM
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('home'));
Route::get('/home', fn () => view('home'));
Route::get('/contact', fn () => view('contact'));
Route::get('/header', fn () => view('header'));
Route::get('/footer', fn () => view('footer'));

/*
|--------------------------------------------------------------------------
| GALERI & LIST HARGA
|--------------------------------------------------------------------------
*/
Route::get('/listharga', [BundlingController::class, 'index'])
    ->name('listharga');

Route::get('/galeri/detail', [GalleryController::class, 'index'])
    ->name('galeri.detail');

Route::get('/galeri/{id}', [BundlingController::class, 'show'])
    ->name('galeri.show');

Route::prefix('galeri')->group(function () {
    Route::get('/baby', fn () => redirect()->route('galeri.detail', ['category' => 'baby']));
    Route::get('/birthday', fn () => redirect()->route('galeri.detail', ['category' => 'birthday']));
    Route::get('/couple', fn () => redirect()->route('galeri.detail', ['category' => 'couple']));
    Route::get('/family', fn () => redirect()->route('galeri.detail', ['category' => 'family']));
    Route::get('/graduation', fn () => redirect()->route('galeri.detail', ['category' => 'graduation']));
    Route::get('/prewed', fn () => redirect()->route('galeri.detail', ['category' => 'prewed']));
});

/*
|--------------------------------------------------------------------------
| AUTH (GUEST)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])
    ->name('register');

    Route::post('/register', [AuthController::class, 'register']);

    /*
    | Forgot Password + OTP (LOGIN)
    */
    
    // Route::post('/forgot-password/reset-password', [AuthController::class, 'resetPassword'])
    // ->name('password.update');
    // Route::get('/forgot-password/new-password',[AuthController::class, 'showResetPasswordForm'])
    //     ->name('password.new');
    
    Route::get('/forgot-password', [AuthController::class, 'forgotPasswordForm'])
    ->name('password.forgot');
    
    Route::post('/forgot-password', [AuthController::class, 'sendOtpForgotPassword'])
    ->name('password.forgot.send');

    Route::get('/forgot-password/verify-otp', [AuthController::class, 'verifyOtpForm'])
    ->name('password.otp.form');
    
    Route::post('/forgot-password/verify-otp', [AuthController::class, 'verifyOtp'])
    ->name('password.otp.verify');
    
    Route::get('/forgot-password/new-password', [AuthController::class, 'newPasswordForm'])
        ->name('password.new');

    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
    ->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])
        ->name('password.reset');

    Route::post('/forgot-password/reset-password', [AuthController::class, 'saveNewPassword'])
        ->name('password.update');
  
    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])
        ->name('otp.resend');
});

    Route::middleware('auth')->get('/profile/change-password', function () {
        if (! session('otp_verified')) {
            return redirect()->route('profile.index');
        }

        return view('profile.profile-change-password');
    })->name('profile.password.form');

/*
|--------------------------------------------------------------------------
| AUTH (LOGIN GOOGLE)
|--------------------------------------------------------------------------
*/
Route::get('/login/google', [AuthController::class, 'redirectToGoogle'])
    ->name('login.google');

Route::get('/login/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::get('/register/complete', [AuthController::class, 'showCompleteRegisterForm'])
    ->name('register.complete');

Route::post('/register/complete', [AuthController::class, 'completeRegister'])
    ->name('register.complete.post');

/*
|--------------------------------------------------------------------------
| AUTH (LOGIN)
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

/*
|--------------------------------------------------------------------------
| HISTORI PROFILE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/pesanan-saya', [OrderController::class, 'myOrders'])
        ->name('orders.my');
});


/*
|--------------------------------------------------------------------------
| EMAIL VERIFICATION
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/email/verify', fn () => view('auth.verify-email'))
        ->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Link verifikasi sudah dikirim!');
    })->middleware('throttle:6,1')->name('verification.send');
});

/*
|--------------------------------------------------------------------------
| PROFILE + OTP PROFIL (SUDAH LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile.index');

    Route::post('/profile/update', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::post('/profile/send-otp', [AuthController::class, 'sendOtpFromProfile'])
        ->name('profile.sendOtp');

    Route::get('/profile/verify-otp', [AuthController::class, 'verifyOtpProfileForm'])
        ->name('profile.otp.form');

    Route::post('/profile/verify-otp', [AuthController::class, 'verifyOtpProfile'])
        ->name('profile.otp.verify');

    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password.update');
});

/*
|--------------------------------------------------------------------------
| ORDER
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');

    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])
        ->name('orders.update-status');
});

/*
|--------------------------------------------------------------------------
| BOOKING
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/booking/{id}', [BookingController::class, 'index'])
        ->name('booking');

    Route::post('/booking/store', [BookingController::class, 'store'])
        ->name('booking.store');
});

/*
|--------------------------------------------------------------------------
| PAYMENT
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/payment/{order}', [PaymentController::class, 'create'])
        ->name('payment.create');

    Route::post('/payment', [PaymentController::class, 'store'])
        ->name('payment.store');
});

/*
|--------------------------------------------------------------------------
| ROUTE OTP LAMA (DISIMPAN - TIDAK DIPAKAI)
|--------------------------------------------------------------------------
*/
// Route::get('/verify-otp', [AuthController::class, 'verifyOtpForm'])->name('otp.form');
// Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify');
// Route::post('/profile/verify-otp', [AuthController::class, 'verifyOtpProfile'])
//     ->name('profile.otp.verify');

