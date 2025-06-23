<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProjectController;


use App\Http\Controllers\Admin\NotificationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// ✅ Admin login routes - PUBLIC (before auth middleware)
//Route::get('admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
//Route::post('admin/login', [LoginController::class, 'login'])->name('admin.login.submit');

// ✅ Protected admin panel routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('admin.profile');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('admin.profile.update');
    Route::post('/logout', [UserController::class, 'logout'])->name('admin.logout');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('billing', [BillingController::class, 'index'])->name('billing.index');
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('settings', [SettingController::class, 'index'])->name('settings');
});

// ✅ Regular user dashboard
/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

// ==========================
// Admin Panel (requires auth)
// ==========================
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('admin.profile');
// Replace this
// Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('admin.profile.update');

// With this
Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('admin.profile.update');
    Route::post('/logout', [UserController::class, 'logout'])->name('admin.logout');

    // Notifications
    Route::get('/notification/read/{id}', [NotificationController::class, 'markAsRead'])->name('notification.read');

    // Optional: Separate admin profile routes (only if different from UserController)
Route::get('/admin/profile', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('admin.profile');
    //Route::put('/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update.form');
});

// ==========================
// Authenticated user profile
// ==========================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ✅ Social login routes
Route::get('/auth/google', [SocialLoginController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [SocialLoginController::class, 'handleGoogleCallback']);

require __DIR__.'/auth.php';
