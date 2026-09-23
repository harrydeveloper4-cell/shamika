<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Renter\PropertySearchController;

Route::middleware(['web', 'auth', 'role:renter'])->prefix('renter')->name('renter.')->group(function () {
    Route::get('/properties', [PropertySearchController::class, 'index'])->name('properties.index');
    Route::get('/properties/{property}', [PropertySearchController::class, 'show'])->name('properties.show');
    Route::post('/properties/{property}/request-viewing', [PropertySearchController::class, 'requestViewing'])->name('properties.requestViewing');
    Route::get('/bookings', [PropertySearchController::class, 'bookingRequest'])->name('properties.bookingRequest');
});

// Public routes for property search and viewing (without authentication)
Route::middleware(['web'])->group(function () {
    Route::get('/search', [PropertySearchController::class, 'index'])->name('properties.search');
    Route::get('/property/{property}', [PropertySearchController::class, 'show'])->name('properties.view');
});
