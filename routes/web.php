<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Http\Controllers\HomeDashboardController;
use App\Http\Controllers\NewBusinessController;
use App\Http\Controllers\RenewalBusinessTransactionController;
use App\Http\Controllers\UserController;

// Home dashboard route
Route::get('/dashboard', [HomeDashboardController::class,'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // Laravel default account settings routes
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // Lockscreen route
    Route::get('/lockscreen', function(){
        return view('livewire.main.lockscreen');
    })->name('new_business_modify');

    // New Business Insurance
    Route::get('/new-business', [NewBusinessController::class, 'index'])->name('new_business.index');
    Route::get('/new-business/data', [NewBusinessController::class, 'newBusinessDatatable'])->name('new_business.data');
    Route::get('/new-business/pending-counts', [NewBusinessController::class, 'nbPendingCounts'])->name('new_business.counts');
    Route::get('/new-business/modify', [NewBusinessController::class, 'newBusinessModify'])->name('new_business_modify');

    Route::get('/new-business/insurance-staff', [NewBusinessController::class,'insuranceStaff',])->name('new_business.insurance_staff');

    Route::get('/new-business/customers', [NewBusinessController::class,'customers',])->name('new_business.customers');

    Route::get('/new-business/vehicles', [NewBusinessController::class,'vehicles',])->name('new_business.vehicles');

    Route::get('/new-business/payments', [NewBusinessController::class,'payments',])->name('new_business.payments');

    Route::get('/new-business/call-logs', [NewBusinessController::class,'callLogs',])->name('new_business.call_logs');

    // Renewal Business Insurance
    Route::get('/renewal-business', [RenewalBusinessTransactionController::class, 'index'])->name('renewal_business');

    Route::get('/renewal-business/data', [RenewalBusinessTransactionController::class, 'renewalBusinessDatatable'])->name('renewal_business.data');

    Route::get('/renewal-business/modify', [RenewalBusinessTransactionController::class, 'renewalBusinessModify'])->name('renewal_business_modify');

    // // Lists
    // Route::get('/customers', [TransactionController::class, 'customerList'])->name('customer_list');
    // Route::get('/vehicles', [TransactionController::class, 'vehicleList'])->name('vehicle_list');

    // Settings Sub-Routes
    Route::get('/users', [UserController::class, 'index'])->name('user');
    Route::get('/account', [UserController::class, 'account'])->name('user_account');

    // Route::get('/reports/nbrb', [ReportController::class, 'nbrbReport'])->name('nbrb_report');
});

require __DIR__.'/auth.php';
