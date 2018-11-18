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


Route::get('/cek_kabupaten', function () {
    return view('cek_kabupaten');
});

Route::POST('/cek_ongkir', function () {
    return view('cek_ongkir');
});

Route::get('/index', function () {
    return view('index');
});



Route::resource('tugas','TugasController');
Route::resource('ongkir', 'Rajaongkir');
