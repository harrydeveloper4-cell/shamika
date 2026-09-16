<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IndexController;

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/about', [IndexController::class, 'about'])->name('about');
Route::get('/contact', [IndexController::class, 'contact'])->name('contact');
Route::get('/get-properties', [IndexController::class, 'properties'])->name('properties');
Route::get('/property-detail/{property}', [IndexController::class, 'property'])->name('property.show');

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('vendor')) {
        return redirect()->route('vendor.properties.index');
    } elseif ($user->hasRole('property_management_team')) {
        return redirect()->route('pm-team.inspections.index');
    } elseif ($user->hasRole('renter')) {
        return redirect()->route('renter.properties.index');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/apply-viewing', [IndexController::class, 'applyViewing'])->name('renter.apply-viewing');

});

Route::post('/submit_inquiry', [IndexController::class, 'submit_inquiry'])->name('submit_inquiry');

// Route::middleware(['auth', 'role:renter'])->group(function () {
//     Route::post('/apply-viewing', [IndexController::class, 'applyViewing'])->name('renter.apply-viewing');
// });

require __DIR__.'/auth.php';
