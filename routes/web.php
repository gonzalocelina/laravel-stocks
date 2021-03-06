<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
    return view('login');
})->name('login');
Route::get('auth/facebook', 'Auth\FacebookController@login')->name('auth.facebook');
Route::get('stocks', function () {
    return view('stocks');
})->middleware('auth')->name('stocks');
Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

