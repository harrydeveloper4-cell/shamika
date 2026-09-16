<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyManagementTeam\InspectionController;

Route::middleware(['auth', 'role:property_management_team'])->prefix('pm-team')->name('pm-team.')->group(function () {
    Route::get('/inspections', [InspectionController::class, 'index'])->name('inspections.index');
    Route::get('/inspections/{inspection}', [InspectionController::class, 'show'])->name('inspections.show');
    Route::put('/inspections/{inspection}/schedule', [InspectionController::class, 'schedule'])->name('inspections.schedule');
    Route::put('/inspections/{inspection}/conduct', [InspectionController::class, 'conduct'])->name('inspections.conduct');
    Route::put('/inspections/{inspection}/submit-report', [InspectionController::class, 'submitReport'])->name('inspections.submit-report');
});
