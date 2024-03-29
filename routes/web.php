<?php

use App\Http\Controllers\AdminController;
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
    return view('welcome');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/cliente', [App\Http\Controllers\ClienteController::class, 'index'])->name('cliente');
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
//Route::get('/admin/corsi', [AdminController::class, 'test'])->name('admin.test');

Route::post('/cancella/{id}', [App\Http\Controllers\ClienteController::class, 'delete'])->name('cancellautente');


Auth::routes();