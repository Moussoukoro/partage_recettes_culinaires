<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RecetteController;
use App\Http\Controllers\CommentaireController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('layouts.app');
});


Route::get('login', [AuthController::class, 'loginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'registerForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
use App\Http\Controllers\HomeController;

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
// Routes pour les recettes
Route::middleware(['auth'])->group(function () {
    Route::resource('recettes', RecetteController::class);
    Route::get('/mes-recettes', [RecetteController::class, 'mesRecettes'])->name('mes-recettes');
    Route::post('/commentaires', [CommentaireController::class, 'store'])->name('commentaires.store');
   
});
Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/recettes/{recette}/aimer', [RecetteController::class, 'aimer'])
        ->name('recettes.aimer');
    Route::post('/recettes/{recette}/favori', [RecetteController::class, 'favori'])
        ->name('recettes.favori');
});


