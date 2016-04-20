<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// USE ONLY ON LOCAL ENV, CAN BE SECURITY RISK
// Route::get('phpinfo', function() {
// 	echo phpinfo();
// });

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
  Route::auth(); // controls the authentication routes (login, logout, forgot password)
	
	Route::get('/', function() {
		return redirect('admin/dashboard');
	});

	Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'middleware' => ['auth']], function() {
		Route::get('dashboard', 'AdminController@getDashboard')->name('dashboard');

		// RESTful Routes in Alphabetical order
		Route::resource('accounts', 'AccountsController');
		Route::resource('allocations', 'DepotAllocationsController');
		Route::resource('billing', 'BillingOfficesController');
		Route::resource('customers', 'CustomersController');
		Route::resource('depots', 'DepotsController');
		Route::resource('devices', 'DevicesController');
		Route::resource('drivers', 'DriversController');
		Route::resource('headers', 'DepotHeadersController');
		Route::resource('leases', 'LeasesController');
		Route::resource('mileages', 'LeaseMileageController');
		Route::resource('operators', 'OperatorsController');
		Route::resource('rates', 'RatesController');
		Route::resource('shipments', 'ShipmentsController');
		Route::resource('strappings', 'TankStrappingsController');
		Route::resource('tanks', 'TanksController');
		Route::resource('trailers', 'TrailersController');
		Route::resource('trucks', 'TrucksController');
		Route::resource('users', 'UsersController');

		Route::post('shipments/ajax', 'ShipmentsController@postAjaxRequest');
	});
});
