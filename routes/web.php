<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

// Controllers
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
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\SettingsController;
/*
|--------------------------------------------------------------------------
| Web Routes - NUPost Project
|--------------------------------------------------------------------------
*/

// Default Redirect
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes for Guests
Route::middleware('guest.nupost')->group(function () {
    Route::get('/login',         [LoginController::class,    'index'])->name('login');
    Route::post('/login',        [LoginController::class,    'store'])->name('login.store');
    Route::get('/register',      [RegisterController::class, 'index'])->name('register');
    Route::post('/register',     [RegisterController::class, 'store'])->name('register.store');

    // OTP and Verification
    Route::get('/verify',        [OtpController::class, 'index'])->name('otp.index');
    Route::post('/verify',       [OtpController::class, 'store'])->name('otp.store');
    Route::get('/verify/resend', [OtpController::class, 'resend'])->name('otp.resend');

    // Password Recovery
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

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Requests — static routes FIRST, then dynamic {id} routes
    Route::get('/requests',            [RequestController::class, 'index'])->name('requests');
    Route::get('/requests/create',     [RequestController::class, 'create'])->name('requests.create');
    Route::post('/requests',           [RequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/{id}/edit',  [RequestController::class, 'edit'])->name('requests.edit');
    Route::post('/requests/{id}/edit', [RequestController::class, 'update'])->name('requests.update');
    Route::delete('/requests/{id}',    [RequestController::class, 'destroy'])->name('requests.destroy');
    Route::get('/requests/{id}/chat',  [RequestController::class, 'chat'])->name('requests.chat');
    Route::post('/requests/{id}/chat', [RequestController::class, 'sendChat'])->name('requests.chat.send');
    Route::get('/requests/{id}', [RequestManagementController::class, 'show'])->name('requests.show');
Route::post('/requests/{id}/generate-caption', [RequestManagementController::class, 'generateCaption'])->name('requests.generate-caption');
Route::post('/requests/{id}/save-caption', [RequestManagementController::class, 'saveCaption'])->name('requests.save-caption');

    // Calendar & Notifications
    Route::get('/calendar',      [RequestController::class,      'calendar'])->name('calendar');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');

    // Profile & Settings
    Route::get('/profile',             [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit',        [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/edit',       [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/settings',            [ProfileController::class, 'settings'])->name('settings');
    Route::post('/settings/password',  [ProfileController::class, 'updatePassword'])->name('settings.password');
    Route::post('/settings/save',      [ProfileController::class, 'saveSettings'])->name('settings.save');
});

// ─── ADMIN ROUTES ──────────────────────────────────────────────────────────
Route::middleware('auth.nupost:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',               [AdminDashboardController::class,    'index'])->name('dashboard');
    Route::get('/requests',                [RequestManagementController::class, 'index'])->name('requests');
    Route::get('/calendar', [RequestManagementController::class, 'calendar'])->name('calendar');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
Route::get('/reports',   [ReportsController::class,   'index'])->name('reports');
Route::get('/reports/export', [ReportsController::class, 'export'])->name('reports.export');
Route::get('/settings',  [SettingsController::class,  'index'])->name('settings');
    Route::get('/requests/{id}',           [RequestManagementController::class, 'show'])->name('requests.show');
    Route::post('/requests/status',        [RequestManagementController::class, 'updateStatus'])->name('requests.status');
    Route::post('/requests/comment',       [RequestManagementController::class, 'postComment'])->name('requests.comment');
    Route::get('/requests/{id}/comments',  [RequestManagementController::class, 'getComments'])->name('requests.comments');
});

// ─── GEMINI AI CAPTION GENERATION ─────────────────────────────────────────
Route::post('/api/generate-caption', function (Request $request) {
    $apiKey = env('GEMINI_API_KEY');

    if (!$apiKey) {
        return response()->json(['error' => 'API Key is missing in .env file.'], 500);
    }

    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-lite-latest:generateContent?key=" . $apiKey;

    $promptText = "Write a short, engaging social media caption for this university post:
Title: {$request->title}
Description: {$request->description}
Category: {$request->category}
Platforms: {$request->platforms}
Provide ONLY the caption text. No labels, no explanations, just the caption.";

    try {
        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->timeout(60)
            ->withoutVerifying()
            ->post($url, [
                'contents' => [
                    ['parts' => [['text' => $promptText]]]
                ],
                'generationConfig' => [
                    'temperature'     => 0.7,
                    'maxOutputTokens' => 500,
                ],
            ]);

        $data = $response->json();

        if ($response->successful() && isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            return response()->json(['caption' => trim($data['candidates'][0]['content']['parts'][0]['text'])]);
        }

        $msg = $data['error']['message'] ?? 'Unknown API Error';
        return response()->json(['error' => 'Google API Error: ' . $msg], 400);

    } catch (\Exception $e) {
        return response()->json(['error' => 'Server Connection Error: ' . $e->getMessage()], 500);
    }
})->middleware('auth.nupost:requestor');