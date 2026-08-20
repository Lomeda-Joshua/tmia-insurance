<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeDashboardController;
use App\Http\Controllers\NewBusinessController;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard', [HomeDashboardController::class,'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // New Business Insurance
    Route::get('/new-business', [NewBusinessController::class, 'index'])->name('new_business');
    Route::get('/new-business/modify', [NewBusinessController::class, 'newBusinessModify'])->name('new_business_modify');

    // Renewal Business Insurance
    Route::get('/renewal-business', [TransactionController::class, 'renewalBusiness'])->name('renewal_business');
    Route::get('/renewal-business/modify', [TransactionController::class, 'renewalBusinessModify'])->name('renewal_business_modify');

    // Lists
    Route::get('/customers', [TransactionController::class, 'customerList'])->name('customer_list');
    Route::get('/vehicles', [TransactionController::class, 'vehicleList'])->name('vehicle_list');

    // Settings Sub-Routes
    Route::get('/users', [UserController::class, 'index'])->name('user');
    Route::get('/account', [UserController::class, 'account'])->name('user_account');

    Route::get('/reports/nbrb', [ReportController::class, 'nbrbReport'])->name('nbrb_report');
});

require __DIR__.'/auth.php';
