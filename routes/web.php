<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\HousekeeperController;

// Welcome route - redirect authenticated users to their dashboard
Route::get('/', function () {
    if (session()->has('authenticated')) {
        $user = session('user');
        switch ($user['role']) {
            case 'admin':
                return redirect('/admin/dashboard');
            case 'supervisor':
                return redirect('/supervisor/dashboard');
            case 'housekeeper':
                return redirect('/housekeeper/dashboard');
            default:
                return view('welcome');
        }
    }
    return view('welcome');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes - Protected by CheckRole middleware
Route::middleware(['auth.custom', 'check.role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

    // User Management
    Route::resource('admin/users', UserController::class)->names('admin.users');

    // Task Management
    Route::resource('admin/tasks', TaskController::class)->names('admin.tasks');

    // Inventory Management
    Route::resource('admin/inventory', InventoryController::class)->names('admin.inventory');

    // Reports
    Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::post('/admin/reports/export', [ReportController::class, 'export'])->name('admin.reports.export');
});

// Supervisor Routes
Route::middleware(['auth.custom', 'check.role:supervisor'])->group(function () {
    Route::get('/supervisor/dashboard', function () {
        return view('supervisor.dashboard');
    });

    // Housekeeper Management
    Route::get('/supervisor/housekeepers', [SupervisorController::class, 'housekeepersIndex'])->name('supervisor.housekeepers.index');
    Route::get('/supervisor/housekeepers/{user}', [SupervisorController::class, 'housekeepersShow'])->name('supervisor.housekeepers.show');

    // Performance Tracking
    Route::get('/supervisor/performance', [SupervisorController::class, 'performanceIndex'])->name('supervisor.performance.index');

    // Task Management
    Route::get('/supervisor/tasks', [SupervisorController::class, 'tasksIndex'])->name('supervisor.tasks.index');
    Route::get('/supervisor/tasks/create', [SupervisorController::class, 'tasksCreateForm'])->name('supervisor.tasks.create');
    Route::post('/supervisor/tasks', [SupervisorController::class, 'tasksStore'])->name('supervisor.tasks.store');
    Route::get('/supervisor/tasks/approval', [SupervisorController::class, 'tasksApprovalIndex'])->name('supervisor.tasks.approval');
    Route::post('/supervisor/tasks/{task}/approve', [SupervisorController::class, 'tasksApprove'])->name('supervisor.tasks.approve');
    Route::post('/supervisor/tasks/{task}/reject', [SupervisorController::class, 'tasksReject'])->name('supervisor.tasks.reject');

    // Inventory Oversight
    Route::get('/supervisor/inventory', [SupervisorController::class, 'inventoryIndex'])->name('supervisor.inventory.index');
    Route::get('/supervisor/inventory/{inventory}', [SupervisorController::class, 'inventoryShow'])->name('supervisor.inventory.show');

    // Reports
    Route::get('/supervisor/reports', [SupervisorController::class, 'reportsIndex'])->name('supervisor.reports.index');
});

// Housekeeper Routes
Route::middleware(['auth.custom', 'check.role:housekeeper'])->group(function () {
    Route::get('/housekeeper/dashboard', [HousekeeperController::class, 'dashboard'])->name('housekeeper.dashboard');

    // Task Management
    Route::get('/housekeeper/tasks', [HousekeeperController::class, 'tasksIndex'])->name('housekeeper.tasks.index');
    Route::get('/housekeeper/tasks/{task}', [HousekeeperController::class, 'tasksShow'])->name('housekeeper.tasks.show');
    Route::post('/housekeeper/tasks/{task}', [HousekeeperController::class, 'tasksUpdate'])->name('housekeeper.tasks.update');

    // Profile
    Route::get('/housekeeper/profile', [HousekeeperController::class, 'profileShow'])->name('housekeeper.profile.show');

    // Inventory Viewing
    Route::get('/housekeeper/inventory', [HousekeeperController::class, 'inventoryIndex'])->name('housekeeper.inventory.index');
    Route::get('/housekeeper/inventory/{inventory}', [HousekeeperController::class, 'inventoryShow'])->name('housekeeper.inventory.show');
});