<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceActionsController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DevicemodelController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HandoverController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Pdfcontroller;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ReadOnlyController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StationaryController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::controller(LoginController::class)->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
});


Route::group(['middleware' => 'auth'], function(){

    Route::get('/logout', [LoginController::class,'logout'])->name('logout');

    Route::get('activeHandovers', [ReadOnlyController::class,'getActiveHandovers'])->name('activeHandover.RO');
    Route::get('activeHandovers/search', [ReadOnlyController::class,'activeHandoversSearch'])->name('activeHandoverSearch.RO');


    Route::group(['middleware' => 'isAdmin'], function (){

   Route::get('/', [DashboardController::class,'index'])->name('dashboard');

    //for the dropdown in devices.create.blade
    Route::get('/models', [DeviceController::class,'getModels']);

    Route::get('admin/handovers/pending',               [HandoverController::class,'getPendingOffboardings'])   ->name('pendingHandovers');
    Route::get('admin/handovers/offboarding',           [HandoverController::class,'getActiveHandovers'])       ->name('activeHandovers');
    Route::post('admin/handovers/offboarding/selected', [HandoverController::class,'selectOffboarding'])              ->name('handovers.selected');
    Route::get('admin/handovers/offboarding/selected',  [HandoverController::class, 'selectOffboarding'])             ->name('selectedReturns');

    Route::post('admin/handovers/updateData', [HandoverController::class, 'updateOffboardingData'])->name('handovers.updateData');

    Route::get('/names', [EmployeeController::class,'getEmployeeForOnboarding'])->name('nameSearch');
    Route::get('/employeeSearch', [EmployeeController::class,'searchEmployee'])->name('employees.search');

    Route::post('handovers/onboarding',[HandoverController::class, 'onBoarding'])->name('handovers.onboarding');
    Route::post('handovers/manageOffboarding',[HandoverController::class, 'offboardingOrPdf'])->name('manageRequestOffboarding');

    Route::get('devices/search',                        [DeviceController::class,'deviceOverviewSearch'])   ->name('devices.overviewSearch');
    Route::get('devices/stationarySearch',              [StationaryController::class,'stationarySearch'])       ->name('devices.stationarySearch');
    Route::get('handover/pendingSearch',          [HandoverController::class,'handoversPendingSearch']) ->name('handovers.pendingSearch');
    Route::get('handover/activeSearch',          [HandoverController::class,'activeHandoversSearch']) ->name('handovers.search');
    Route::get('handovers/indexSearch',                [HandoverController::class,'allHandoversSearch'])  ->name('handovers.allHandoversSearch');

    Route::get('devicemodels/devicemodelSearch',  [DevicemodelController::class,'devicemodelSearch'])      ->name('devicemodels.devicemodelSearch');


    Route::get('devices/stationaryDevices',[StationaryController::class, 'index'])->name('stationaryDevices');
    Route::get('devices/stationaryDevices/{device}/edit',[StationaryController::class, 'edit'])->name('stationary.edit');
    Route::match(['put', 'patch'],'devices/stationaryDevices/{device}',[StationaryController::class, 'update'])->name('stationary.update');

    Route::get('orders',[OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{oid}/edit',[OrderController::class, 'edit'])->name('orders.edit');
    Route::post('orders/arrived',[OrderController::class, 'markAsArrived'])->name('orders.MarkArrived');

    Route::get('orders/search',[OrderController::class, 'getOrdersSearch'])->name('orders.search');


    Route::get('devices/autocomplete-search',[DeviceController::class, 'autocompleteSearch'])->name('autocomplete');

    Route::get('devices/OrdersForAdd',[DeviceController::class, 'getOrdersForDeviceAdd'])->name('getOrdersForDeviceAdd');

    Route::post('devices/actions',[DeviceController::class,'editActions'])->name('devices.actions');

    Route::controller(EmployeeController::class)->group(function(){
        Route::get('employees-export', 'export')->name('employees.export');
        Route::post('employees-import', 'import')->name('employees.import');
    });
    Route::controller(DeviceController::class)->group(function(){
        Route::get('device-export', 'export')->name('devices.export');
        Route::get('device-export-filter', 'exportWithFilter')->name('devices.exportFilter');
    });

    Route::Resources([
        'devices' => DeviceController::class,
        'types' => TypeController::class,
        'locations' => LocationController::class,
        'devicemodels' => DevicemodelController::class,
        'handovers' => HandoverController::class,
        'users' => UserController::class,
        'employees' => EmployeeController::class,
    ]);

    }); // admin middleware end
}); // group auth end




