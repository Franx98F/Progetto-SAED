<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware(['auth:api'])->group(function () {
    //Operazioni di gestione e creazione corso scii per maestri
    Route::post('/tipo', [App\Http\Controllers\ApiController::class, 'createtipo'])->name('api.tipo');
    Route::post('/corso', [App\Http\Controllers\ApiController::class, 'createcorso'])->name('api.crea_corso');
    Route::get('/mostracorsi', [App\Http\Controllers\ApiController::class, 'mostracorsi'])->name('api.mostra_corsi');
    Route::put('/updatecorso/{idCorso}', [App\Http\Controllers\ApiController::class, 'updatecorso'])->name('api.modifica_corso');
    Route::delete('/deletecorso/{idCorso}', [App\Http\Controllers\ApiController::class, 'deletecorso'])->name('api.cancella_corso');

    //Operazioni di gestione prenotazioni ed iscrizioni per clienti impianto scii
    Route::post('/iscrizione/{iscrizione}', [App\Http\Controllers\ApiController::class, 'iscrizione'])->name('api.iscrizione_allievo');
    Route::delete('/deleteiscrizione/{idCorso}/{idUtente}', [App\Http\Controllers\ApiController::class, 'deleteiscrizione'])->name('api.disiscrizione_allievo');
});


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
