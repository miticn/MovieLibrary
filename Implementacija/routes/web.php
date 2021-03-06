<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GostController;
use App\Http\Controllers\KorisnikController;
use App\Http\Controllers\BaseController;

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

Route::get('/', [BaseController::class, 'indexPage'])->name('index');
Route::get('/{index}',  [BaseController::class, 'indexPage'])->where('index', 'index|home|pocetna');
Route::get('/search',[BaseController::class, 'search'])->name('search');
Route::get('/create',[KorisnikController::class, 'createPage'])->middleware('auth')->name('createPage');
Route::get('/createMovie',[KorisnikController::class, 'createPageMovie'])->middleware('auth')->name('createPageMovie');
Route::get('/createActor',[KorisnikController::class, 'createPageActor'])->middleware('auth')->name('createPageActor');
Route::post('/createActor',[KorisnikController::class, 'createActor'])->middleware('auth')->name('createActor');
Route::post('/createMovie',[KorisnikController::class, 'createMovie'])->middleware('auth')->name('createMovie');
Route::get('/movie/{id}',[BaseController::class, 'movie'])->name('movie');
Route::post('/movie/{id}/comment',[KorisnikController::class, 'comment'])->middleware('auth')->name('commentMovie');
Route::post('/movie/{id}/removeComment/{commId}',[KorisnikController::class, 'removeComment'])->middleware('auth')->name('removeComment');
Route::post('/roleRemove/{idMovie}/{idActor}',[KorisnikController::class, 'removeRole'])->middleware('auth')->name('removeRole');
Route::post('/addRole/{idMovie}/{idActor}',[KorisnikController::class, 'addRole'])->middleware('auth')->name('addRole');


Route::get('/actor/{id}',[BaseController::class, 'actor'])->name('actor');
Route::post('/actor/{id}/comment',[KorisnikController::class, 'comment'])->middleware('auth')->name('commentActor');

Route::get('/login', [GostController::class, 'login'])->middleware('guest')->name('login');
Route::get('/register', [GostController::class, 'register'])->middleware('guest')->name('register');
Route::post('/login_submit', [GostController::class, 'login_submit'])->middleware('guest')->name('login_submit');
Route::post('/register_submit', [GostController::class, 'register_submit'])->middleware('guest')->name('register_submit');

Route::get('/logout', [KorisnikController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/profile/{id}', [BaseController::class, 'profile'])->name('profile');
Route::get('/lista/{id}', [BaseController::class, 'lista'])->name('lista');

Route::get('/izmeni', [KorisnikController::class, 'izmeni'])->middleware('auth')->name('izmeni');
Route::post('/izmeni_submit', [KorisnikController::class, 'izmeni_submit'])->middleware('auth')->name('izmeni_submit');

Route::post('/oceni/{indikator}/{lokacija}/{vrsta}', [KorisnikController::class, 'oceni'])->middleware('auth')->name('oceni');

Route::post('/cuvanje_filma/{lista}/{film}', [KorisnikController::class, 'sacuvaj_film'])->middleware('auth')->name('sacuvaj_film');
Route::post('/zaboravljanje_filma/{lista}/{film}', [KorisnikController::class, 'zaboravi_film'])->middleware('auth')->name('zaboravi_film');

Route::post('/napravi_listu', [KorisnikController::class, 'napravi_listu'])->middleware('auth')->name('napravi_listu');
Route::post('/lista/sacuvaj/{id}', [KorisnikController::class, 'sacuvaj_listu'])->middleware('auth')->name('sacuvaj_listu');
Route::post('/lista/zaboravi/{id}', [KorisnikController::class, 'zaboravi_listu'])->middleware('auth')->name('zaboravi_listu');
Route::post('/profile/sacuvaj/{id}', [KorisnikController::class, 'sacuvaj_korisnika'])->middleware('auth')->name('sacuvaj_korisnika');
Route::post('/profile/zaboravi/{id}', [KorisnikController::class, 'zaboravi_korisnika'])->middleware('auth')->name('zaboravi_korisnika');