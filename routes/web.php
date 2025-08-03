<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NetworkDeviceController;
use App\Http\Controllers\RegionController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Customer Management
    Route::resource('customers', CustomerController::class);
    
    // Network Device Management
    Route::resource('network-devices', NetworkDeviceController::class);
    
    // Region Management
    Route::resource('regions', RegionController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
