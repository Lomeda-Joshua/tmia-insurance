<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Http\Controllers\HomeDashboardController;
use App\Http\Controllers\NewBusinessController;
use App\Http\Controllers\RenewalBusinessTransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VehicleController;
use Illuminate\Http\Request;


// ==========================================
// 1. Lockscreen Routes (Bypass Unlocked Check)
// ==========================================
Route::middleware(['auth'])->group(function () {

    // Livewire Volt lockscreen component
    Volt::route('/lockscreen', 'main.lockscreen')->name('lockscreen');

    // Manually trigger lockscreen
    Route::get('/lock', function () {

        // Save current URL for redirect after unlock
        $previousUrl = url()->previous();

        if (
            $previousUrl &&
            $previousUrl !== route('lockscreen')
        ) {
            session()->put('url.intended', $previousUrl);
        }
        // Use ONE session key consistently
        session()->put('lockscreen_locked', true);
        return redirect()->route('lockscreen');
    })->name('lock');


});


// ==========================================
// 2. Protected Application Routes (Must be Unlocked)
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {

    // Home dashboard
    Route::get('/dashboard', [HomeDashboardController::class, 'index'])->name('dashboard');

    // Transactions Group
    Route::prefix('transactions')->group(function () {
        // New Business Insurance
        Route::get('/new-business', [NewBusinessController::class, 'index'])->name('new_business.index');
        Route::get('/new-business/data', [NewBusinessController::class, 'newBusinessDatatable'])->name('new_business.data');
        Route::get('/new-business/pending-counts', [NewBusinessController::class, 'nbPendingCounts'])->name('new_business.counts');
        Route::get('/new-business/modify', [NewBusinessController::class, 'newBusinessModify'])->name('new_business_modify');
        Route::get('/new-business/insurance-staff', [NewBusinessController::class, 'insuranceStaff'])->name('new_business.insurance_staff');
        Route::get('/new-business/customers', [NewBusinessController::class, 'customers'])->name('new_business.customers');
        Route::get('/new-business/vehicles', [NewBusinessController::class, 'vehicles'])->name('new_business.vehicles');
        Route::get('/new-business/payments', [NewBusinessController::class, 'payments'])->name('new_business.payments');
        Route::get('/new-business/call-logs', [NewBusinessController::class, 'callLogs'])->name('new_business.call_logs');

        // Renewal Business Insurance
        Route::get('/renewal-business', [RenewalBusinessTransactionController::class, 'index'])->name('renewal_business');
        Route::get('/renewal-business/data', [RenewalBusinessTransactionController::class, 'renewalBusinessDatatable'])->name('renewal_business.data');
        Route::get('/renewal-business/modify', [RenewalBusinessTransactionController::class, 'renewalBusinessModify'])->name('renewal_business_modify');

        // Lists        
        Route::get('/customers', [CustomerController::class, 'index'])->name('customer_list');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
        Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

        // Data API Endpoints for DataTables / AJAX
        Route::get('/api/customers', [CustomerController::class, 'getCustomers'])->name('customers.data');
        Route::post('/customers/import', [CustomerController::class, 'import'])->name('customers.import');




        Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicle_list');
    });

    // Settings Group
    Route::prefix('settings')->group(function () {
        // User settings    
        Route::get('/users', [UserController::class, 'index'])->name('user');
        Route::get('/users/data', [UserController::class, 'userData'])->name('users.data');
        Route::get('/users/levels', [UserController::class, 'levels'])->name('users.levels');
        Route::get('/users/{userId}', [UserController::class, 'show'])->whereNumber('userId')->name('users.show');
        Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
        Route::delete('/users/{userId}', [UserController::class, 'destroy'])->whereNumber('userId')->name('users.destroy');

        // Account settings
        Route::get('/account', [UserController::class, 'account'])->name('user_account');
        Route::put('/account', [UserController::class, 'updateAccount'])->name('user_account.update');
    });

    // Laravel default Volt account settings routes
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
