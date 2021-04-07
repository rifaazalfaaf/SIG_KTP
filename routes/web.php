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
//     return view('app/home/home');
// });

Route::get('/','HomeController@index');
Route::get('/visualisasi_data','VisualisasiController@index');
Route::get('/prediksi_data','PrediksiController@index');
Route::get('/input_data','PrediksiController@input_data');
Route::post('/import', 'PrediksiController@import')->name('import');