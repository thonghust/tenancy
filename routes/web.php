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
use App\User;

// Route::domain('{domain}.tenancy.com')->group(function () {
//     Route::get('/', function ($domain) {
//         $users = User::get();
//         foreach($users as $user)
//         {
//         	echo $user->name."<br>";
//         }
//     });
// });

Route::group(['middleware' => 'system.enforce'], function () {
	Route::get('/', function () {
		return redirect()->route('login');
	});
});

Route::group(['middleware' => 'tenancy.enforce'], function () {
	Auth::routes();
	Route::resource('articles', 'ArticleController')->middleware('tenant');
});

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('websites', 'WebsiteController')->middleware('admin');

Route::resource('customers', 'CustomerController')->middleware('admin');

Route::resource('hostnames', 'HostnameController')->middleware('admin');

