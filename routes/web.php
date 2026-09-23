<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\StripeWebhookController;

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

Route::middleware(['auth', 'role:admin|vendor'])->group(function () {
    Route::get('/booking-request-accept-to-pay/{booking}', [IndexController::class, 'acceptToPay'])->name('booking-request.accept-to-pay');
});

Route::middleware(['auth', 'role:renter'])->group(function () {
    Route::get('/booking-request-accept-to-pay/{booking}', [IndexController::class, 'acceptToPay'])->name('booking-request.accept-to-pay');

    Route::get('/paynow/{booking}', [IndexController::class, 'paynow'])->name('renter.booking-request.paynow');
    Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook'])->name('stripe.webhook');

    Route::get('/checkout/success/{booking}', [IndexController::class, 'checkoutSuccess'])->name('checkout.success');
    Route::get('/checkout/cancel/{booking}', [IndexController::class, 'checkoutCancel'])->name('checkout.cancel');

});


require __DIR__.'/auth.php';
