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
    return view('welcome');
});

Auth::routes();

Route::get('/transactions', 'TransactionActivityController@dashboard')->name('transactions');
Route::post('/deposit', 'TransactionActivityController@deposit')->name('deposit');
Route::post('/withdraw', 'TransactionActivityController@withdraw')->name('withdraw');

Route::get('/report/{days?}', 'TransactionController@previewReport')->name('report');
