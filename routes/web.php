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


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//USUARIOS
Route::resource('usuarios', 'UserController');
Route::get('user-tabla', 'UserController@tabla')->name('user-tabla');

//ESTABLECIMIENTOS
Route::resource('establecimientos', 'EstablecimientoController');
Route::get('est-tabla', 'EstablecimientoController@tabla')->name('est-tabla');