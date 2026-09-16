<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vendor\PropertyController;

Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    // Property Management
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
    Route::put('/properties/{property}/archive', [PropertyController::class, 'archive'])->name('properties.archive');

    // Monitoring Request
    Route::post('/properties/{property}/submit-monitoring-request', [PropertyController::class, 'submitMonitoringRequest'])->name('properties.submit-monitoring-request');
});
