<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Admin\CheckupController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Staff\StaffCheckupController;

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
     // 1️⃣ List & search students
    Route::get('patients', [PatientController::class, 'index'])->name('patients.index');

    // 2️⃣ View a specific student and their records
    Route::get('patients/{user}', [PatientController::class, 'show'])->name('patients.show');

    // 3️⃣ Create a new record (clinic session or medical history)
    Route::get('patients/{user}/records/create', [PatientController::class, 'createRecord'])
        ->name('patients.records.create');

    // 4️⃣ Store the new record
    Route::post('patients/{user}/records', [PatientController::class, 'storeRecord'])
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

    });


// Staff Profile
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [StaffController::class, 'profile'])->name('profile');

    Route::get('checkups', [StaffCheckupController::class, 'index'])->name('checkups.index');
    Route::get('checkups/{checkup}', [StaffCheckupController::class, 'show'])->name('checkups.show');
    Route::post('checkups/{checkup}/update', [StaffCheckupController::class, 'update'])->name('checkups.update');
});


Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [PatientController::class, 'profile'])->name('profile');
    Route::post('/profile', [PatientController::class, 'updateProfile'])->name('profile.update');
        
});
