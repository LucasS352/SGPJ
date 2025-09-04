<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProcessoController;
use App\Http\Controllers\FolderController;
use App\Models\Folder;

Route::get('/', fn() => view('welcome'));
Route::get('/login', fn() => view('pages.login'))->name('login');

Route::get('/processos', [ProcessoController::class, 'index'])->name('processos.index');
Route::patch('/processos/{processo}/status', [ProcessoController::class, 'updateStatus'])->name('processos.updateStatus');
Route::post('/folders/{folder}/add_processos', [ProcessoController::class, 'assignToFolder'])->name('processos.assignToFolder');

Route::get('/pastas', [FolderController::class, 'index'])->name('pastas.index');
Route::post('/pastas', [FolderController::class, 'store'])->name('pastas.store');
Route::get('/pastas/{folder}', [FolderController::class, 'show'])->name('pastas.show');
Route::patch('/pastas/{folder}/processos/{processo}', [FolderController::class, 'updateProcesso'])->name('pastas.updateProcesso');
Route::delete('/pastas/{folder}/processos/{processo}', [FolderController::class, 'removeProcesso'])->name('pastas.removeProcesso');