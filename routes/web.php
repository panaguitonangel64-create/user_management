<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\Auth\RegisterController;

// Guest Routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('home');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Role-based Dashboards (Protected by Auth & Role Middleware)
Route::middleware(['auth'])->group(function () {

    // Administrator Routes
    Route::middleware(['role:Administrator'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Only Staff and Administrator can view the users table
    Route::middleware(['role:Staff,Administrator'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
    });

    // Staff Routes
    Route::middleware(['role:Staff'])->group(function () {
        Route::get('/staff/dashboard', [DashboardController::class, 'staff'])->name('staff.dashboard');
    });

    // Customer Routes
    Route::middleware(['role:Customer'])->group(function () {
        Route::get('/customer/dashboard', [DashboardController::class, 'customer'])->name('customer.dashboard');
    });
});