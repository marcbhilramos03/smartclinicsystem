<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Admin\CheckupController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Patient\RecordsController;
use App\Http\Controllers\Staff\StaffCheckupController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\PatientRecordController;

// -a----------------------------
// Default: Patient Login
// -----------------------------
Route::get('/', [LoginController::class, 'showPatientLoginForm'])
    ->name('patient.login.form'); // Default login page

Route::get('/patient-login', [LoginController::class, 'showPatientLoginForm'])
    ->name('patient.login.form'); // Explicit route for patient login
Route::post('/patient-login', [LoginController::class, 'patientLogin'])
    ->name('patient.login');      // Patient login POST

// -----------------------------
// Admin / Staff Login
// -----------------------------
Route::get('/admin-login', [LoginController::class, 'showLoginForm'])
    ->name('admin.login.form');   // Admin/staff login page
Route::post('/admin-login', [LoginController::class, 'login'])
    ->name('login-admin');        // Admin/staff login POST

// -----------------------------
// Logout
// -----------------------------
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// -----------------------------
// Dashboard
// -----------------------------
Route::get('/dashboard', function () {
    $user = auth()->user();

    if (!$user) return redirect('/'); // redirect to patient login

    switch ($user->role) {
        case 'admin':
            return view('admin.dashboard');
        case 'staff':
            return view('staff.dashboard');
        case 'patient':
            return view('patient.dashboard');
        default:
            abort(403, 'Unauthorized');
    }
})->middleware('auth');

Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    Route::get('/search/patients', [SearchController::class, 'search'])->name('search.patients');
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Admin Dashboard & Profile
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
        Route::post('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');

           Route::resource('users', UserController::class)->names([
        'index'   => 'users.index',
        'create'  => 'users.create',
        'store'   => 'users.store',
        'edit'    => 'users.edit',
        'update'  => 'users.update',
        'destroy' => 'users.destroy',
    ]);
     
    // Patients CRUD
    Route::get('patients', [PatientRecordController::class, 'index'])->name('patients.index');
    Route::get('patients/{user}', [PatientRecordController::class, 'show'])->name('patients.show');
    Route::get('patients/{user}/records/create', [PatientRecordController::class, 'createRecord'])
        ->name('patients.records.create');
    Route::post('patients/{user}/records', [PatientRecordController::class, 'storeRecord'])
        ->name('patients.records.store');

    Route::get('checkups', [CheckupController::class, 'index'])->name('checkups.index');
    Route::get('checkups/create', [CheckupController::class, 'create'])->name('checkups.create');
    Route::post('checkups', [CheckupController::class, 'store'])->name('checkups.store');

    // Inventory CRUD
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{inventory}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{inventory}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

    // Archived inventory
    Route::get('/inventory/archived', [InventoryController::class, 'archived'])->name('inventory.archived');

    Route::get('/reports/inventory', [ReportsController::class, 'inventoryReport'])->name('reports.inventory');
    Route::get('/reports/checkups', [ReportsController::class, 'checkupsReport'])->name('admin.reports.checkups');
    Route::get('/reports/patients', [ReportsController::class, 'patientReport'])->name('reports.patients');

    });


// Staff Profile
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [StaffController::class, 'profile'])->name('profile');
    Route::post('/profile', [StaffController::class, 'updateProfile'])->name('profile.update');

    Route::get('checkups', [StaffCheckupController::class, 'index'])->name('checkups.index');
    Route::get('checkups/{checkup}', [StaffCheckupController::class, 'show'])->name('checkups.show');
    Route::post('checkups/{checkup}/update', [StaffCheckupController::class, 'update'])->name('checkups.update');

    Route::get('records', [MedicalRecordController::class, 'index'])->name('records.index');

});


Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [PatientController::class, 'profile'])->name('profile');
    Route::post('/profile', [PatientController::class, 'updateProfile'])->name('profile.update');

     Route::get('/medical-records', [RecordsController::class, 'index'])->name('medical_records.index');
    Route::get('/medical-records/show/{type}/{id}', [RecordsController::class, 'show'])->name('medical_records.show');
});

