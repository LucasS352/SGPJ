<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProcessoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/processos', [ProcessoController::class, 'index'])->name('processos.index');
Route::patch('/processos/{processo}/status', [ProcessoController::class, 'updateStatus'])->name('processos.updateStatus');
Route::post('/folders/{folder}/add_processos', [ProcessoController::class, 'assignToFolder'])->name('processos.assignToFolder');