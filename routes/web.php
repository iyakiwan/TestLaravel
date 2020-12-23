<?php

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

// Route::get('/', function () {
//     return view('login');
// });

// Auth::routes();
Route::get('/login','ViewFinanceController@login')->name('view.login');
Route::post('/login','ViewFinanceController@loginAction')->name('action.login');
Route::get('/logout','ViewFinanceController@logoutAction')->name('view.logout');

Route::get('/','ViewFinanceController@home')->name('view.home');
Route::get('/pemasukan','ViewFinanceController@pemasukan')->name('view.pemasukan');
Route::get('/pengeluaran','ViewFinanceController@pengeluaran')->name('view.pengeluaran');
Route::get('/arus','ViewFinanceController@aruskas')->name('view.aruskas');
Route::get('/bulanan','ViewFinanceController@labarugi')->name('view.labarugi');
Route::get('/status','ViewFinanceController@status')->name('view.status');

Route::get('/validasi','ViewFinanceController@validasi')->name('view.validasi');
Route::get('/validasi/{id}','ViewFinanceController@validation')->name('view.validation');
Route::post('/validasi/{id}/action','ViewFinanceController@validationAction')->name('view.validation.action');

Route::get('/kas','ViewFinanceController@kasIndex')->name('view.kasIndex');
Route::post('/kas','ViewFinanceController@kasCreate')->name('action.kasCreate');
Route::delete('/kas/{id}','ViewFinanceController@kasDelete')->name('action.kasDelete');

// Route::get('/home', 'ViewFinanceController@home')->name('home');