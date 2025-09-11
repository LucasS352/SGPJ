<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProcessoController;
use App\Http\Controllers\FolderController;
use App\Models\Folder;

// Route::get('/', fn() => view('welcome'));
// Route::get('/', fn() => view('login'))->name('login');

// Login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Recuperação de senha "fake" para não quebrar
Route::get('/forgot-password', function () {
    return redirect()->route('login')->with('error', 'Recuperação de senha não disponível.');
})->name('password.request');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/processos', function () {
    return view('processos.index');
})->middleware('auth');

Route::get('/processos', [ProcessoController::class, 'index'])->name('processos.index');
Route::patch('/processos/{processo}/status', [ProcessoController::class, 'updateStatus'])->name('processos.updateStatus');
Route::post('/folders/{folder}/add_processos', [FolderController::class, 'addProcessos'])->name('pastas.addProcessos');

Route::get('/pastas', [FolderController::class, 'index'])->name('pastas.index');
Route::post('/pastas', [FolderController::class, 'store'])->name('pastas.store');
Route::get('/pastas/{folder}', [FolderController::class, 'show'])->name('pastas.show');
Route::patch('/pastas/{folder}/processos/{processo}', [FolderController::class, 'updateProcesso'])->name('pastas.updateProcesso');
Route::delete('/pastas/{folder}/processos/{processo}', [FolderController::class, 'removeProcesso'])->name('pastas.removeProcesso');