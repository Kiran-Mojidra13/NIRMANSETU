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
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DailyProgressPhotoController;
use App\Http\Controllers\ContractorDashboardController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Contractor\ContractorProjectController;
use App\Http\Controllers\Contractor\ContractorTaskController;
use App\Http\Controllers\Contractor\DailyProgressController;
// site images
//use App\Http\Controllers\ImageController;
use App\Http\Controllers\Contractor\SiteImageController;
use App\Http\Controllers\Contractor\ProfileController as ContractorProfileController;

//client
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\ProjectController as ClientProjectController;
use App\Http\Controllers\Client\BillsController as ClientBillsController;
use App\Http\Controllers\Client\DocumentController as ClientDocumentsController;
use App\Http\Controllers\Client\DailyUpdatesController as ClientDailyUpdatesController;
use App\Http\Controllers\Client\ProfileController as ClientProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

    Route::get('/force-logout', function() {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});


// ✅ Admin login routes - PUBLIC (before auth middleware)
//Route::get('admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
//Route::post('admin/login', [LoginController::class, 'login'])->name('admin.login.submit');

// ✅ Group all with 'admin.' name prefix
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
   Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/change-password', [UserController::class, 'changePassword'])->name('profile.changePassword');
    Route::match(['get', 'post'], '/logout', [UserController::class, 'logout'])->name('logout');


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
/*Route::prefix('engineer')->middleware(['auth', 'engineer'])->name('engineer.')->group(function () {
    Route::get('/engineer/dashboard', [EngineerDashboardController::class, 'index'])
    ->name('engineer.dashboard')
    ->middleware(['auth']); // Add your custom middleware if needed

});*/
// Engineer routes


/*Route::prefix('contractor')->middleware(['auth', 'engineer'])->name('contractor.')->group(function () {
    Route::get('/dashboard', function () {
        return view('contractor.dashboard');
    })->name('dashboard');*/

Route::middleware(['auth', 'engineer'])->prefix('contractor')->name('contractor.')->group(function () {
    Route::get('/dashboard', [ContractorDashboardController::class, 'index'])->name('dashboard');

    Route::get('/projects', function () {
        return view('contractor.projects');
    })->name('projects');
    Route::get('/projects', [ContractorProjectController::class, 'index'])->name('projects');

    Route::get('/tasks', [ContractorTaskController::class, 'index'])->name('assigned-tasks');

Route::get('/daily-updates', [DailyProgressController::class, 'index'])->name('daily-updates');
Route::get('/daily-updates/create', [DailyProgressController::class, 'create'])->name('daily_update.create');
Route::post('/daily-updates/store', [DailyProgressController::class, 'store'])->name('daily_update.store');
Route::put('/contractor/daily-updates/{id}', [DailyProgressController::class, 'update'])->name('daily-updates.update');
Route::delete('/contractor/daily-updates/{id}', [DailyProgressController::class, 'destroy'])->name('daily-updates.destroy');

   // ✅ Site Images
    Route::get('/site-images', [SiteImageController::class, 'index'])->name('site_images');
    Route::post('/site-images/{id}', [SiteImageController::class, 'store'])->name('site_images.store');
    Route::delete('/site-images/{id}', [SiteImageController::class, 'destroy'])->name('site_images.destroy');

    // Route::get('/calendar', function () {
    //     return view('contractor.calendar');
    // })->name('calendar');
    // calender
    // Calendar page
Route::get('/calendar', [\App\Http\Controllers\Contractor\CalendarController::class, 'index'])
    ->name('calendar');

// Events feed for FullCalendar (JSON)
Route::get('/calendar/events', [\App\Http\Controllers\Contractor\CalendarController::class, 'events'])
    ->name('calendar.events');

// Contractor Site Visits CRUD
Route::post('/site-visits', [\App\Http\Controllers\Contractor\CalendarController::class, 'storeVisit'])
    ->name('site_visits.store');
Route::put('/site-visits/{id}', [\App\Http\Controllers\Contractor\CalendarController::class, 'updateVisit'])
    ->name('site_visits.update');
Route::delete('/site-visits/{id}', [\App\Http\Controllers\Contractor\CalendarController::class, 'destroyVisit'])
    ->name('site_visits.destroy');


    //profile
Route::get('/profile', [ContractorProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ContractorProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ContractorProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/change-password', [ContractorProfileController::class, 'changePassword'])
        ->name('profile.change_password');

});





Route::middleware(['auth', 'role:client,customer'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/projects', [ClientProjectController::class, 'index'])->name('projects'); // <-- fixed
    //Route::get('/bills', [ClientDashboardController::class, 'bills'])->name('bills');
    Route::get('/bills', [ClientBillsController::class,'index'])->name('bills');
    //Route::get('/get-razorpay-order/{billId}', [ClientBillsController::class,'getRazorpayOrder']);
    Route::post('/bills/{bill}/mark-paid', [ClientBillsController::class, 'markAsPaid'])->name('bills.markPaid');
    Route::get('/documents', [ClientDocumentsController::class, 'index'])->name('documents');
    Route::get('/daily_updates', [ClientDailyUpdatesController::class, 'index'])->name('daily_updates');
    Route::get('/profile', [ClientProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ClientProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/change-password', [ClientProfileController::class, 'changePassword'])->name('profile.change_password');
        Route::delete('/profile', [ClientProfileController::class, 'destroy'])->name('profile.destroy');
});





// Route::prefix('client')->middleware(['auth', 'client'])->name('client.')->group(function () {
//     Route::get('/dashboard', function () {
//         return view('client.dashboard');
//     })->name('dashboard');
// });
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
