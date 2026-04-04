<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Requestor\DashboardController;
use App\Http\Controllers\Requestor\RequestController;
use App\Http\Controllers\Requestor\ProfileController;
use App\Http\Controllers\Requestor\NotificationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RequestManagementController;

// ─── DEFAULT REDIRECT ──────────────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

// ─── AUTH ROUTES ───────────────────────────────────────────────────────────
Route::middleware('guest.nupost')->group(function () {
    Route::get('/login',    [LoginController::class,    'index'])->name('login');
    Route::post('/login',   [LoginController::class,    'store'])->name('login.store');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register',[RegisterController::class, 'store'])->name('register.store');
    Route::get('/verify',   [OtpController::class,      'index'])->name('otp.index');
    Route::post('/verify',  [OtpController::class,      'store'])->name('otp.store');
    Route::get('/verify/resend', [OtpController::class, 'resend'])->name('otp.resend');

    // Forgot Password
    Route::get('/forgot-password',         [ForgotPasswordController::class, 'index'])->name('password.forgot');
    Route::post('/forgot-password',        [ForgotPasswordController::class, 'sendOtp'])->name('password.send');
    Route::get('/forgot-password/verify',  [ForgotPasswordController::class, 'verifyIndex'])->name('password.verify');
    Route::post('/forgot-password/verify', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify.store');
    Route::get('/forgot-password/reset',   [ForgotPasswordController::class, 'resetIndex'])->name('password.reset');
    Route::post('/forgot-password/reset',  [ForgotPasswordController::class, 'resetPassword'])->name('password.reset.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// ─── REQUESTOR ROUTES ──────────────────────────────────────────────────────
Route::middleware('auth.nupost:requestor')->prefix('requestor')->name('requestor.')->group(function () {
    Route::get('/dashboard',          [DashboardController::class,    'index'])->name('dashboard');
    Route::get('/requests',           [RequestController::class,      'index'])->name('requests');
    Route::get('/requests/create',    [RequestController::class,      'create'])->name('requests.create');
    Route::post('/requests',          [RequestController::class,      'store'])->name('requests.store');
    Route::get('/requests/{id}/chat', [RequestController::class,      'chat'])->name('requests.chat');
    Route::post('/requests/{id}/chat',[RequestController::class,      'sendChat'])->name('requests.chat.send');
    Route::get('/calendar',           [RequestController::class,      'calendar'])->name('calendar');
    Route::get('/notifications',      [NotificationController::class, 'index'])->name('notifications');
    Route::get('/profile',            [ProfileController::class,      'index'])->name('profile');
    Route::get('/profile/edit',       [ProfileController::class,      'edit'])->name('profile.edit');
    Route::post('/profile/edit',      [ProfileController::class,      'update'])->name('profile.update');
    Route::get('/settings',           [ProfileController::class,      'settings'])->name('settings');
    Route::post('/settings/password', [ProfileController::class,      'updatePassword'])->name('settings.password');
    Route::post('/settings/save',     [ProfileController::class,      'saveSettings'])->name('settings.save');
});

// ─── ADMIN ROUTES ──────────────────────────────────────────────────────────
Route::middleware('auth.nupost:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',              [AdminDashboardController::class,    'index'])->name('dashboard');
    Route::get('/requests',               [RequestManagementController::class, 'index'])->name('requests');
    Route::post('/requests/status',       [RequestManagementController::class, 'updateStatus'])->name('requests.status');
    Route::post('/requests/comment',      [RequestManagementController::class, 'postComment'])->name('requests.comment');
    Route::get('/requests/{id}',          [RequestManagementController::class, 'show'])->name('requests.show');
    Route::get('/requests/{id}/comments', [RequestManagementController::class, 'getComments'])->name('requests.comments');
});