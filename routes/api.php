<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProcessoController;
use App\Http\Controllers\Api\FolderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/processos', [ProcessoController::class, 'index']);
Route::patch('/processos/{processo}/status', [ProcessoController::class, 'updateStatus']);

Route::get('/folders', [FolderController::class, 'index']);
Route::post('/folders', [FolderController::class, 'store']);
Route::get('/folders/{folder}', [FolderController::class, 'show']);
Route::post('/folders/{folder}/add_processos', [FolderController::class, 'addProcessos']);
Route::patch('/folders/{folder}/processos/{processo}', [FolderController::class, 'updateProcesso']);
Route::delete('/folders/{folder}/processos/{processo}', [FolderController::class, 'removeProcesso']);