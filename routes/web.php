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
use App\Http\Controllers\Admin\ClinicSessionController;
use App\Http\Controllers\Admin\PatientImportController;
use App\Http\Controllers\Admin\PatientRecordController;
use App\Http\Controllers\Admin\MedicalHistoryController;
use App\Http\Controllers\Patient\PatientCheckupController;
use App\Http\Controllers\Staff\StaffCheckupRecordController;
use App\Http\Controllers\Patient\PatientMedicalRecordController;



// Homepage
Route::get('/', function () {
    return view('homepage');
})->name('homepage');
// -----------------------------
// Default: Patient Login
// -----------------------------
// Route::get('/', [LoginController::class, 'showPatientLoginForm'])->name('patient.login.form');
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
        case 'admin':
            return redirect()->route('admin.dashboard'); // ✅ Calls controller
        case 'staff':
            return redirect()->route('staff.dashboard');
        case 'patient':
            return redirect()->route('patient.dashboard');
        default:
            abort(403, 'Unauthorized');
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
    Route::get('/dashboard-stats', [AdminController::class, 'getStats'])->name('stats');
    Route::get('/dashboard-chart', [AdminController::class, 'getChartData'])->name('chart');

    
    // Users CRUD
    Route::resource('users', UserController::class);
    Route::resource('patients', PatientRecordController::class);

    
    Route::get('/imports/patients', [PatientImportController::class, 'showPatientImportForm'])->name('imports.patients.form');
    Route::post('/imports/patients', [PatientImportController::class, 'importPatients'])->name('imports.patients.submit');

    Route::get('/imports/medical-histories', [PatientImportController::class, 'showMedicalHistoryImportForm'])->name('imports.medical_histories.form');
    Route::post('/imports/medical-histories', [PatientImportController::class, 'importMedicalHistory'])->name('imports.medical_histories.submit');
   
   
    // Nested routes for clinic sessions and medical histories

    Route::prefix('patients/{patient}')->group(function () {
        Route::get('clinic_sessions/create', [ClinicSessionController::class, 'create'])
            ->name('patients.clinic_sessions.create');
        Route::post('clinic_sessions', [ClinicSessionController::class, 'store'])
            ->name('patients.clinic_sessions.store');

        Route::get('medical_histories/create', [MedicalHistoryController::class, 'create'])
            ->name('patients.medical_histories.create');
        Route::post('medical_histories', [MedicalHistoryController::class, 'store'])
            ->name('patients.medical_histories.store');
    });

    // Optional: list all medical histories and clinic sessions globally
    Route::resource('medical_histories', MedicalHistoryController::class)->only(['index', 'show']);
    Route::resource('clinic_sessions', ClinicSessionController::class)->only(['index', 'show']);
   
    // Patient edit first (specific)
    Route::get('checkups/patient/{id}/edit', [CheckupController::class, 'editPatientRecord'])->name('checkups.edit_patient');
    Route::put('checkups/patient/{id}', [CheckupController::class, 'updatePatientRecord'])->name('checkups.update_patient');

    // Checkups CRUD (general)
    Route::get('checkups', [CheckupController::class, 'index'])->name('checkups.index');
    Route::get('checkups/create', [CheckupController::class, 'create'])->name('checkups.create');
    Route::post('checkups', [CheckupController::class, 'store'])->name('checkups.store');
    Route::get('checkups/{checkup}', [CheckupController::class, 'show'])->name('checkups.show');
    Route::delete('checkups/{checkup}', [CheckupController::class, 'destroy'])->name('checkups.destroy');

 
});

// -----------------------------
// Staff Routes
// -----------------------------
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {

    // Dashboard & Profile
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [StaffController::class, 'profile'])->name('profile');
    Route::post('/profile', [StaffController::class, 'updateProfile'])->name('profile.update');

    // Staff Assigned Checkups
    Route::resource('checkups', StaffCheckupController::class)->only(['index', 'show']);

    // View students per checkup
    Route::get('checkups/{checkupId}/students', [StaffCheckupController::class, 'students'])
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
    
    // Dashboard
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [PatientController::class, 'profile'])->name('profile');


    Route::get('/checkups', [PatientCheckupController::class, 'index'])->name('checkups.index');
    Route::get('/checkups/{checkup}', [PatientCheckupController::class, 'show'])->name('checkups.show');

    // View all medical records
    Route::get('/medical-records', [PatientMedicalRecordController::class, 'index'])->name('medical_records.index');
    Route::get('/medical-records/{record}', [PatientMedicalRecordController::class, 'show'])->name('medical_records.show');
});
