<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MonitoringRequestController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CommissionSettingController;
use App\Http\Controllers\Vendor\PropertyController;
use App\Http\Controllers\Admin\PayoutController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\TestimonialController;



Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // User & Vendor Management Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::put('/vendors/{user}/approve', [UserController::class, 'approveVendor'])->name('vendors.approve');
    Route::put('/vendors/{user}/reject', [UserController::class, 'rejectVendor'])->name('vendors.reject');
    Route::post('/property-management-team', [UserController::class, 'createPropertyManagementTeamAccount'])->name('property-management-team.store');

    // Property Management Routes
    // Route::get('/properties', [PropertyController::class, 'get'])->name('properties');
    Route::resource('/properties', PropertyController::class);
    // Monitoring Request Management Routes
    Route::get('/monitoring-requests', [MonitoringRequestController::class, 'index'])->name('monitoring-requests.index');
    Route::get('/monitoring-requests/{monitoringRequest}', [MonitoringRequestController::class, 'show'])->name('monitoring-requests.show');
    Route::put('/monitoring-requests/{monitoringRequest}/review', [MonitoringRequestController::class, 'review'])->name('monitoring-requests.review');
    Route::put('/monitoring-requests/{monitoringRequest}/assign-inspector', [MonitoringRequestController::class, 'assignInspector'])->name('monitoring-requests.assign-inspector');

    // Verification Management Routes
    Route::get('/verifications', [VerificationController::class, 'index'])->name('verifications.index');
    Route::get('/verifications/{inspection}', [VerificationController::class, 'show'])->name('verifications.show');
    Route::put('/verifications/{property}/decide', [VerificationController::class, 'decide'])->name('verifications.decide');

    // Route::resource('/subscription-plans', SubscriptionPlanController::class);
    Route::resource('/commission-settings', CommissionSettingController::class);
    Route::resource('/payouts', PayoutController::class);

    Route::resource('/config', ConfigController::class);
    Route::resource('/faq', FaqController::class);
    Route::resource('/testimonials', TestimonialController::class);
    Route::get('/inquries', [UserController::class, 'inquries'])->name('inquries.index');    
    Route::delete('/inquries/{inquiry}', [UserController::class, 'destroy'])->name('inquries.destroy');
});