<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Http\Controllers\HomeDashboardController;
use App\Http\Controllers\NewBusinessController;
use App\Http\Controllers\RenewalBusinessTransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OverallDataController;
use App\Http\Middleware\EnsureLockscreenIsUnlocked;
use App\Http\Controllers\LockscreenController;



Route::middleware(['auth'])->group(function () {
    Route::get('/lockscreen', [LockscreenController::class, 'show'])->name('lockscreen');
    Route::post('/lockscreen/unlock', [LockscreenController::class, 'unlock'])->name('lockscreen.unlock');
    Route::post('/lockscreen/lock', [LockscreenController::class, 'lock'])->name('lockscreen.lock');
});

Route::middleware(['auth', EnsureLockscreenIsUnlocked::class])->group(function () {

    // Home dashboard
    Route::get('/dashboard', [HomeDashboardController::class, 'index'])->name('dashboard');

    // Data Group
    Route::post('/bodytype/data', [OverallDataController::class, 'getBodyType'])->name('bodytype.data');
    Route::post('/communicationtype/data', [OverallDataController::class, 'getCommunicationType'])->name('communicationtype.data');
    Route::post('/ewalletype/data', [OverallDataController::class, 'getEwalletType'])->name('ewalletype.data');
    Route::post('/fueltype/data', [OverallDataController::class, 'getFuelType'])->name('fueltype.data');
    Route::post('/insurancetype/data', [OverallDataController::class, 'getInsuranceType'])->name('insurancetype.data');
    Route::post('/paymenttype/data', [OverallDataController::class, 'getPaymentType'])->name('paymenttype.data');
    Route::post('/banks/data', [OverallDataController::class, 'getBank'])->name('banks.data');
    Route::post('/callstatus/data', [OverallDataController::class, 'getCallStatus'])->name('callstatus.data');
    Route::post('/insuranceco/data', [OverallDataController::class, 'getInsuranceCo'])->name('insuranceco.data');
    Route::post('/region/data', [OverallDataController::class, 'getRegion'])->name('region.data');
    Route::post('/productclass/data', [OverallDataController::class, 'getProductClass'])->name('productclass.data');
    Route::post('/transactionstatus/data', [OverallDataController::class, 'getTrasactionStatus'])->name('transactionstatus.data');



    // Transactions Group
    Route::prefix('transactions')->group(function () {

        // New Business Insurance
        Route::get('/new-business', [NewBusinessController::class, 'index'])->name('new_business.index');
        Route::post('/newbusiness/data', [NewBusinessController::class, 'getNewBusiness'])->name('newbusiness.data');
        Route::post('/new-business/pending-counts', [NewBusinessController::class, 'nbPendingCounts'])->name('new_business.counts');
        Route::get('/new-business/modify', [NewBusinessController::class, 'newBusinessModify'])->name('new_business_modify');
        
        // Renewal Business Insurance
        Route::get('/renewal-business', [RenewalBusinessTransactionController::class, 'index'])->name('renewal_business');
        Route::get('/renewal-business/data', [RenewalBusinessTransactionController::class, 'renewalBusinessDatatable'])->name('renewal_business.data');
        Route::get('/renewal-business/modify', [RenewalBusinessTransactionController::class, 'renewalBusinessModify'])->name('renewal_business_modify');

        // Lists        
        Route::get('/customers', [CustomerController::class, 'index'])->name('customer.list');
        Route::get('/customers/data', [CustomerController::class, 'getCustomers'])->name('customers.data');
        Route::post('/customers/import', [CustomerController::class, 'import'])->name('customers.import');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
        Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');


        // Data API Endpoints for DataTables - AJAX
        Route::get('/customers/{custno}', [CustomerController::class, 'show'])->name('customers.show');
        
        Route::get('/customertype/data', [OverallDataController::class, 'getCustomerType'])->name('customers_type.data');
        Route::post('/customertype/data2', [OverallDataController::class, 'getCustomerType'])->name('customers_type.data.2');
        Route::post('/insurance-staff/data', [OverallDataController::class, 'getInsuranceStaff'])->name('insurance_staff.data');                
        Route::get('/vehicles/data', [OverallDataController::class, 'getVehicle'])->name('vehicle.data');
        Route::post('/payments/data', [OverallDataController::class, 'getPaymentType'])->name('payments.data');
        Route::get('/call-logs/data', [OverallDataController::class, 'getCallLogs'])->name('call_logs.data');
        Route::post('/uploadedcustomer/data', [OverallDataController::class, 'getUploadedCustomer'])->name('uploaded.customer');
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
