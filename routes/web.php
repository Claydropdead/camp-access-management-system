<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Visitor Pre-Registration Routes
Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboard');
    })->name('admin.dashboard');
    
    Route::get('/admin/visitors', [BookingController::class, 'adminIndex'])->name('admin.visitors');
    Route::post('/admin/visitors/{id}/action', [BookingController::class, 'adminAction'])->name('admin.visitors.action');
    Route::post('/admin/visitors/bulk-action', [BookingController::class, 'bulkAction'])->name('admin.visitors.bulk-action');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
