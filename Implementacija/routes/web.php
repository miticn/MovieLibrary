<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GostController;
use App\Http\Controllers\KorisnikController;

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

Route::get('/', function () {return view('index');})->name('index');
Route::get('/{index}', function () {return view('index');})->where('index', 'index|home|pocetna');

Route::get('/login', [GostController::class, 'login'])->middleware('guest')->name('login');
Route::get('/register', [GostController::class, 'register'])->middleware('guest')->name('register');
Route::post('/login_submit', [GostController::class, 'login_submit'])->middleware('guest')->name('login_submit');

Route::get('/logout', [KorisnikController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/profil', [KorisnikController::class, 'profil'])->middleware('auth')->name('profil');
