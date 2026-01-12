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
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| HALAMAN UMUM
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);
Route::get('/contact', fn () => view('contact'));

/*
|--------------------------------------------------------------------------
| GALERI & LIST HARGA
|--------------------------------------------------------------------------
*/
Route::get('/listharga', [BundlingController::class, 'index'])->name('listharga');

Route::get('/galeri/{category}', [GalleryController::class, 'index'])
    ->name('galeri.detail');

Route::prefix('galeri')->group(function () {
    Route::get('/baby', fn () => redirect()->route('galeri.detail', 'baby'));
    Route::get('/birthday', fn () => redirect()->route('galeri.detail', 'birthday'));
    Route::get('/couple', fn () => redirect()->route('galeri.detail', 'couple'));
    Route::get('/family', fn () => redirect()->route('galeri.detail', 'family'));
    Route::get('/graduation', fn () => redirect()->route('galeri.detail', 'graduation'));
    Route::get('/prewed', fn () => redirect()->route('galeri.detail', 'prewed'));
});

/*
|--------------------------------------------------------------------------
| AUTH - GUEST
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // Login & Register
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/register/complete', [AuthController::class, 'showCompleteRegisterForm'])
        ->name('register.complete');

    Route::post('/register/complete', [AuthController::class, 'completeRegister'])
        ->name('register.complete.post');


    // Forgot Password + OTP
    Route::get('/forgot-password', [AuthController::class, 'forgotPasswordForm'])
        ->name('password.forgot');

    Route::post('/forgot-password/send-otp', [AuthController::class, 'sendOtpForgotPassword'])
        ->name('password.forgot.send');

    Route::get('/forgot-password/verify-otp', [AuthController::class, 'verifyOtpForm'])
        ->name('password.otp.form');

    Route::post('/forgot-password/verify-otp', [AuthController::class, 'verifyOtp'])
        ->name('password.otp.verify');

    Route::get('/forgot-password/new-password', [AuthController::class, 'newPasswordForm'])
        ->name('password.new');

    Route::post('/forgot-password/reset-password', [AuthController::class, 'saveNewPassword'])
        ->name('password.update');

    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])
        ->name('otp.resend');
});

/*
|--------------------------------------------------------------------------
| AUTH - GOOGLE
|--------------------------------------------------------------------------
*/
Route::get('/login/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [AuthController::class, 'handleGoogleCallback']);

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

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
| PROFILE + OTP PROFIL (LOGIN)
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
    
    Route::get('/profile/change-password', function () {
    return view('profile.profile-change-password');
	
    })->name('profile.password.form')->middleware('auth');

});


/*
|--------------------------------------------------------------------------
| HISTORI PESANAN
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/pesanan-saya', [OrderController::class, 'myOrders'])
        ->name('orders.my');
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

    Route::get('/cetak-payment', [PaymentController::class, 'printPayment'])
        ->name('print.payment');
});

/*
|--------------------------------------------------------------------------
| CETAK
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/cetak-order', [OrderController::class, 'printOrder'])
        ->name('print.order');

    Route::get('/cetak-payment', [PaymentController::class, 'printPayment'])
        ->name('print.payment');
});
