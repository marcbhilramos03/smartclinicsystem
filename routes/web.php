<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Admin\CheckupController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Patient\RecordsController;
use App\Http\Controllers\Staff\StaffCheckupController;
use App\Http\Controllers\Admin\PatientImportController;
use App\Http\Controllers\Admin\PatientRecordController;
use App\Http\Controllers\Staff\StaffCheckupRecordController;

// -----------------------------
// Default: Patient Login
// -----------------------------
Route::get('/', [LoginController::class, 'showPatientLoginForm'])->name('patient.login.form');
Route::get('/patient-login', [LoginController::class, 'showPatientLoginForm'])->name('patient.login.form');
Route::post('/patient-login', [LoginController::class, 'patientLogin'])->name('patient.login');

// -----------------------------
// Admin / Staff Login
// -----------------------------
Route::get('/admin-login', [LoginController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/admin-login', [LoginController::class, 'login'])->name('login-admin');

// -----------------------------
// Logout
// -----------------------------
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// -----------------------------
// Dashboard Redirect
// -----------------------------
Route::get('/dashboard', function () {
    $user = auth()->user();
    if (!$user) return redirect('/');
    switch ($user->role) {
        case 'admin': return view('admin.dashboard');
        case 'staff': return view('staff.dashboard');
        case 'patient': return view('patient.dashboard');
        default: abort(403, 'Unauthorized');
    }
})->middleware('auth');

// -----------------------------
// Search (admin & staff)
// -----------------------------
Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    Route::get('/search/patients', [SearchController::class, 'search'])->name('search.patients');
});

// -----------------------------
// Admin Routes
// -----------------------------
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard & Profile
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');

    // Users CRUD
    Route::resource('users', UserController::class);

    // Patient Import
    Route::get('patients/import', [PatientImportController::class, 'showImportForm'])->name('patients.import-form');
    Route::post('patients/import', [PatientImportController::class, 'import'])->name('patients.import');

    // Patients & Records
    Route::get('patients', [PatientRecordController::class, 'index'])->name('patients.index');
    Route::get('patients/{user}', [PatientRecordController::class, 'show'])->name('patients.show');
    Route::get('patients/{user}/records/create', [PatientRecordController::class, 'createRecord'])->name('patients.records.create');
    Route::post('patients/{user}/records', [PatientRecordController::class, 'storeRecord'])->name('patients.records.store');

    // Checkups CRUD
    Route::resource('checkups', CheckupController::class);

    // Inventory CRUD
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{inventory}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{inventory}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::get('/inventory/archived', [InventoryController::class, 'archived'])->name('inventory.archived');

    // Reports
    Route::get('/reports/inventory', [ReportsController::class, 'inventoryReport'])->name('reports.inventory');
    Route::get('/reports/checkups', [ReportsController::class, 'checkupsReport'])->name('reports.checkups');
    Route::get('/reports/patients', [ReportsController::class, 'patientReport'])->name('reports.patients');
});

// -----------------------------
// Staff Routes
// -----------------------------
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {

    // Dashboard & Profile
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [StaffController::class, 'profile'])->name('profile');
    Route::post('/profile', [StaffController::class, 'updateProfile'])->name('profile.update');

    // Assigned Checkups
    Route::resource('checkups', StaffCheckupController::class)->only(['index','show']);

    // View students per checkup
    Route::get('checkups/{checkupId}/students', [StaffCheckupRecordController::class, 'students'])
        ->name('checkups.students');

    // Records (nested under checkup)
    Route::prefix('checkups/{checkupId}/records')->name('checkup_records.')->group(function () {
        Route::get('create/{studentId}', [StaffCheckupRecordController::class, 'addRecordForm'])->name('create');
        Route::post('store/{studentId}', [StaffCheckupRecordController::class, 'storeRecord'])->name('store');
        Route::get('{recordId}/edit', [StaffCheckupRecordController::class, 'edit'])->name('edit');
        Route::put('{recordId}', [StaffCheckupRecordController::class, 'update'])->name('update');
        Route::delete('{recordId}', [StaffCheckupRecordController::class, 'destroy'])->name('destroy');
    });
});



// -----------------------------
// Patient Routes
// -----------------------------
Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [PatientController::class, 'profile'])->name('profile');
    Route::post('/profile', [PatientController::class, 'updateProfile'])->name('profile.update');

    Route::get('/medical-records', [RecordsController::class, 'index'])->name('medical_records.index');
    Route::get('/medical-records/show/{type}/{id}', [RecordsController::class, 'show'])->name('medical_records.show');
});
