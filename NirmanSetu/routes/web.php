<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\BillingController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\EstimateController;




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

// ✅ Group all with 'admin.' name prefix
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
   Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    // ✅ Manage Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/{id}/update', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/{id}/delete', [UserController::class, 'destroy'])->name('users.delete');
    Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');

    // ✅ Manage Project
 Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects/store', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::post('/projects/{id}/update', [ProjectController::class, 'update'])->name('projects.update');
    Route::post('/projects/{id}/delete', [ProjectController::class, 'destroy'])->name('projects.delete');
    Route::post('/projects/{id}/archive', [ProjectController::class, 'archive'])->name('projects.archive');

// ✅ Task Assignment
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::post('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
Route::post('/tasks/{id}/delete', [TaskController::class, 'destroy'])->name('tasks.delete');

// ✅ Inventory management
Route::get('/inventory', [MaterialController::class, 'index'])->name('inventory.index');
Route::get('/inventory/create', [MaterialController::class, 'create'])->name('inventory.create');
Route::post('/inventory', [MaterialController::class, 'store'])->name('inventory.store');
Route::get('/inventory/{id}/edit', [MaterialController::class, 'edit'])->name('inventory.edit');
Route::post('/inventory/{id}', [MaterialController::class, 'update'])->name('inventory.update');
Route::post('/inventory/{id}/delete', [MaterialController::class, 'destroy'])->name('inventory.delete');

// ✅ Document Management
 Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
Route::get('/documents/{id}/edit', [DocumentController::class, 'edit'])->name('admin.documents.edit');
Route::put('/documents/{id}', [DocumentController::class, 'update'])->name('admin.documents.update');
    Route::post('/documents/{id}/delete', [DocumentController::class, 'destroy'])->name('documents.delete');


   // ✅ Billing
    Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');

    // ✅ Invoices - download
    Route::get('/invoice/{id}/download', [InvoiceController::class, 'download'])->name('invoice.download');

    // ✅ Estimates - download
    Route::get('/estimates/{id}/download', [EstimateController::class, 'download'])->name('estimate.download');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.exportPdf');
    Route::get('/reports/export-excel', [ReportController::class, 'exportExcel'])->name('reports.exportExcel');
    //Route::get('/settings', [SettingController::class, 'index'])->name('settings');
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
Route::put('/admin/profile/update', [UserController::class, 'updateProfile'])->name('admin.profile.update');
Route::put('/admin/profile/change-password', [UserController::class, 'changePassword'])->name('admin.profile.changePassword');

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