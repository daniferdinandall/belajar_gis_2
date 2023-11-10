<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 
// use App\Http\Controllers\PolylineController;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');


Route::resource('sekolahs', App\Http\Controllers\SekolahController::class)->middleware('auth');
Route::resource('markers', App\Http\Controllers\MarkerController::class)->middleware('auth');
Route::resource('circles', App\Http\Controllers\CircleController::class)->middleware('auth');
Route::resource('polygon', App\Http\Controllers\PolygonController::class)->middleware('auth');
Route::resource('polyline', App\Http\Controllers\PolylineController::class)->middleware('auth');