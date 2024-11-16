<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RecetteController;


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
});


