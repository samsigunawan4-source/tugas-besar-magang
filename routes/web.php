<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\VacancyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified', '2fa'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function() {
        Route::get('/vacancies', [\App\Http\Controllers\AdminController::class, 'vacancies'])->name('vacancies.index');
        Route::get('/vacancies/{vacancy}', [\App\Http\Controllers\AdminController::class, 'showVacancy'])->name('vacancies.show');
        Route::post('/vacancies/{vacancy}/approve', [\App\Http\Controllers\AdminController::class, 'approveVacancy'])->name('vacancies.approve');
        Route::get('/logbooks', [\App\Http\Controllers\LogbookController::class, 'index'])->name('logbooks.index');
        
        // User Role Management
        Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users.index');
        Route::put('/users/{user}/role', [\App\Http\Controllers\AdminController::class, 'updateUserRole'])->name('users.update-role');
        Route::delete('/users/{user}', [\App\Http\Controllers\AdminController::class, 'destroyUser'])->name('users.destroy');
        
        // User Management Split
        Route::get('/students', [\App\Http\Controllers\AdminController::class, 'students'])->name('students.index');
        Route::get('/students/{user}', [\App\Http\Controllers\AdminController::class, 'showStudent'])->name('students.show');
        Route::get('/companies', [\App\Http\Controllers\AdminController::class, 'companies'])->name('companies.index');
        Route::get('/companies/{user}', [\App\Http\Controllers\AdminController::class, 'showCompany'])->name('companies.show');
        Route::get('/applications', [\App\Http\Controllers\AdminController::class, 'applications'])->name('applications.index');
        Route::put('/applications/{application}/verify', [\App\Http\Controllers\AdminController::class, 'verifyApplication'])->name('applications.verify');
        Route::resource('skills', \App\Http\Controllers\SkillController::class)->only(['index', 'store', 'destroy']);
    });

    // Company Routes
    Route::middleware(['role:perusahaan'])->prefix('company')->name('company.')->group(function() {
        Route::get('/profile', [ProfileController::class, 'companyEdit'])->name('profile.edit');
        Route::post('/profile', [ProfileController::class, 'companyUpdate'])->name('profile.update');
        Route::resource('vacancies', VacancyController::class);
        Route::resource('applications', \App\Http\Controllers\ApplicationController::class)->only(['index', 'update']);
        Route::post('/applications/{application}/complete', [\App\Http\Controllers\ApplicationController::class, 'completeInternship'])->name('applications.complete');
        Route::get('/logbooks', [\App\Http\Controllers\LogbookController::class, 'index'])->name('logbooks.index');
        Route::put('/logbooks/{logbook}/status', [\App\Http\Controllers\LogbookController::class, 'updateStatus'])->name('logbooks.update-status');
    });

    // Student Routes
    Route::middleware(['role:mahasiswa'])->prefix('student')->name('student.')->group(function() {
        Route::get('/profile', [ProfileController::class, 'studentEdit'])->name('profile.edit');
        Route::post('/profile', [ProfileController::class, 'studentUpdate'])->name('profile.update');
        Route::resource('applications', \App\Http\Controllers\ApplicationController::class)->only(['index', 'create', 'store']);
        Route::post('/applications/{application}/upload-report', [\App\Http\Controllers\ApplicationController::class, 'uploadReport'])->name('applications.upload-report');
        Route::get('/reports', [\App\Http\Controllers\ApplicationController::class, 'reports'])->name('reports.index');
        Route::resource('logbooks', \App\Http\Controllers\LogbookController::class)->only(['index', 'store']);
    });

    // Standard Profile (Email/Password)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 2FA Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/2fa/setup', [TwoFactorController::class, 'setup'])->name('2fa.setup');
    Route::post('/2fa/verify-setup', [TwoFactorController::class, 'verifySetup'])->name('2fa.verify-setup');
    Route::get('/2fa/challenge', [TwoFactorController::class, 'challenge'])->name('2fa.challenge');
    Route::post('/2fa/verify', [TwoFactorController::class, 'verify'])->name('2fa.verify');
});

// Authentication Routes
require __DIR__.'/auth.php';
