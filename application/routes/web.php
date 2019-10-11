<?php

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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin','middleware' => ['auth']], function(){
	Route::resource('users','UsersController');
	Route::get('profile','UsersController@profile')->name('profile');
	Route::post('change_profile','UsersController@change_profile')->name('change_profile');
	Route::post('change_password','UsersController@change_password')->name('change_password');
	Route::get('sales_points','UsersController@sales_points')->name('sales_points');
	Route::resource('sales','SalesController');

	Route::resource('provider-credits','ProviderCreditsController');
});
