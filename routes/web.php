<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Http\Controllers\HomeDashboardController;
use App\Http\Controllers\NewBusinessController;
use App\Http\Controllers\RenewalBusinessController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OverallDataController;
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\EnsureLockscreenIsUnlocked;
use App\Http\Controllers\LockscreenController;
use App\Http\Controllers\GeneralReportingController;


Route::middleware(['auth'])->group(function () {
    Route::get('/lockscreen', [LockscreenController::class, 'show'])->name('lockscreen');
    Route::post('/lockscreen/unlock', [LockscreenController::class, 'unlock'])->name('lockscreen.unlock');
    Route::post('/lockscreen/lock', [LockscreenController::class, 'lock'])->name('lockscreen.lock');
});

Route::middleware(['auth', EnsureLockscreenIsUnlocked::class])->group(function () {

    // Home dashboard
    Route::get('/dashboard', [HomeDashboardController::class, 'index'])->name('dashboard');

    // Notification
    Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications.data');

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

    // Location group
    Route::post('/region/data', [OverallDataController::class, 'getRegion'])->name('region.data');
    Route::post('/province/data', [OverallDataController::class, 'getProvince'])->name('province.data');
    Route::post('/citymunicipal/data', [OverallDataController::class, 'getCityMunicipal'])->name('citymunicipal.data');
    Route::post('/barangay/data', [OverallDataController::class, 'getBarangay'])->name('barangay.data');

    // vehicleinfo group
    Route::post('/productclass/data', [OverallDataController::class, 'getProductClass'])->name('productclass.data');
    Route::post('/transactionstatus/data', [OverallDataController::class, 'getTrasactionStatus'])->name('transactionstatus.data');
    Route::post('/transaction-get-status/data', [CustomerController::class, 'getCurrentStatus'])->name('gettransaction-status.data');

    // Customer info
    Route::post('/customerinfo/data', [OverallDataController::class, 'getCustomerInfoData'])->name('customerinfo.data');
    Route::post('/customervehicleinfo/data', [OverallDataController::class, 'getVehicleInfoData'])->name('customercvehicleinfo.data');

    // Transactions Group
    Route::prefix('transactions')->group(function () {

        // New Business Insurance
        Route::get('/new-business', [NewBusinessController::class, 'index'])->name('new_business.index');
        Route::post('/newbusiness/data', [NewBusinessController::class, 'getNewBusiness'])->name('newbusiness.data');
        Route::post('/new-business/pending-counts', [NewBusinessController::class, 'nbPendingCounts'])->name('new_business.counts');
        Route::get('/new-business/modify', [NewBusinessController::class, 'newBusinessModify'])->name('new_business_modify');
        
        Route::post('/new-business/save', [NewBusinessController::class, 'store'])->name('newbusiness.save');
        Route::post('/new-business/gettransactions', [NewBusinessController::class, 'getTransactionsNB'])->name('getTransactionNB.data');
        Route::get('/new-business/get-modify-view', [NewBusinessController::class, 'getModifyView'])->name('getModifyView.data');
        Route::post('/new-business/specific-customer-data', [CustomerController::class, 'getCustomerSpecificData'])->name('getSpecificView.data');
        Route::post('/session/set-transaction-data', [NewBusinessController::class, 'setTransactionSession'])->name('session.set-transaction-data');
        Route::post('/vehicle/get-by-customer', [NewBusinessController::class, 'getVehiclesByCustomer'])->name('vehicle.get-by-customer');
        Route::post('/uploaded-customers/get', [NewBusinessController::class, 'getUploadedCustomersEdaf'])->name('uploaded-customers-edaf.get');
        Route::post('/new-business/remove-by-insurance-no' , [NewBusinessController::class, 'removeByInsuranceNo'])->name('remove-by-insurance-no.data');

        // Lists        
        Route::get('/customers', [CustomerController::class, 'index'])->name('customer.list');
        Route::post('/customers/data', [CustomerController::class, 'getCustomers'])->name('customers.data');
        Route::post('/customers/import', [CustomerController::class, 'import'])->name('customers.import');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
        Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

        Route::post('/customer/save-from-list', [CustomerController::class, 'saveCustomerFromList'])->name('customer.save');

        Route::post('/customer/get-check-data', [CustomerController::class, 'checkCustomerData'])->name('customer.getCheck-data');
        Route::post('/customer/get-by-no', [CustomerController::class, 'getCustomerByNo'])->name('customer.get-by-no');
        Route::post('/vehicle/search', [CustomerController::class, 'searchVehicle'])->name('vehicle.search');
        Route::post('/vehicle/edaf-search', [CustomerController::class, 'getEdafCustomerVehicle'])->name('edaf.vehicle.search');
        Route::post('/customer/file-nb-upload', [CustomerController::class, 'fileNbUpload'])->name('file.nbupload');
        

        Route::post('/getcustomer/data', [CustomerController::class, 'getCustomerDetails'])->name('getcustomers.data');
        Route::post('/getNewBusinessPayment/data', [NewBusinessController::class, 'getNewBusinessPayment'])->name('getNewBusinessPayment.data');
        Route::post('/transactions/get-by-insurance-no', [CustomerController::class, 'getTransactionsByInsuranceNo'])->name('transactions.get-by-insurance-no');
        Route::post('/payments/get-data', [NewBusinessController::class, 'getNewBusinessPayment'])->name('payments.get-data');

        // Data API Endpoints for DataTables - AJAX
        // Route::get('/customers/{custno}', [CustomerController::class, 'show'])->name('customers.show');
        Route::post('/customertype/data', [OverallDataController::class, 'getCustomerType'])->name('customers_type.data');
        Route::post('/customertype/data-2', [OverallDataController::class, 'getCustomerTypePost'])->name('customers_type.data.2');
        Route::post('/insurance-staff/data', [OverallDataController::class, 'getInsuranceStaff'])->name('insurance_staff.data');                
        Route::post('/vehicles/data', [OverallDataController::class, 'getVehicle'])->name('vehicle.data');
        Route::post('/payments/data', [OverallDataController::class, 'getPaymentType'])->name('payments.data');
        Route::get('/call-logs/data', [OverallDataController::class, 'getCallLogs'])->name('call_logs.data');
        Route::post('/uploadedcustomer/data', [OverallDataController::class, 'getUploadedCustomer'])->name('uploaded.customer');
        Route::post('/userlevel/data', [UserController::class,'userlevels'])->name('userlevels.data');


        // Renewal Business Insurance
        Route::get('/renewal-business', [RenewalBusinessController::class, 'index'])->name('renewal_business');
        Route::post('/renewal-business/data', [RenewalBusinessController::class, 'getRenewalData'])->name('renewal_business.data');
        Route::post('/renewal-business/modify', [RenewalBusinessController::class, 'renewalBusinessModify'])->name('renewal_business_modify');


        // Vehicle
        Route::get('/vehicle', [VehicleController::class, 'index'])->name('vehicle.index');
        Route::post('/vehicle/data', [VehicleController::class, 'getVehicles'])->name('vehicletable.data');
        Route::post('/vehicle/assign-customer', [VehicleController::class, 'assignCustomer'])->name('vehicle.assign-customer');
    });


    // Settings Group
    Route::prefix('settings')->group(function () {
        // User settings    
        Route::get('/users', [UserController::class, 'index'])->name('user');
        Route::post('/users/data', [UserController::class, 'userData'])->name('users.data');
        Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
        Route::post('/user/delete', [UserController::class, 'deleteUser'])->name('user.delete');
        Route::post('user/get-user-data', [UserController::class,  'getUserData'])->name('user.getdata');

        // Account settings
        Route::get('/user-account', [UserController::class, 'account'])->name('user_account');
        Route::get('/user-account/session-variables', [UserController::class, 'getSessionVariables'])->name('getSession.variables');
        Route::post('/user-account/profile-data', [UserController::class, 'getUserProfile'])->name('get_user_profile_data');
        Route::post('/user-account/check-username', [UserController::class, 'checkUsername'])->name('user.check_username');
        Route::post('/user-account/update', [UserController::class, 'updateUser'])->name('user_account.update');
        Route::post('/user-account/levels', [UserController::class, 'userlevels'])->name('users.levels.data');
        Route::post('/user-account/get-user-data', [UserController::class, 'getUserData'])->name('users.get.data');
        Route::post('/user-account/save-new-data', [UserController::class, 'saveNewUserData'])->name('user.save');
    });

    Route::prefix('settings')->group(function () {
        Route::get('/report/new-business-renewal-report', [GeneralReportingController::class, 'index'])->name('general_report.index');
    });

    // Laravel default Volt account settings routes
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
