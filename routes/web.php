<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\TamanhoController;
use App\Http\Controllers\BackupController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas de Clientes
    Route::resource('clientes', ClienteController::class);
    
    // Rotas de Empresas
    Route::resource('empresas', EmpresaController::class);

    // Rotas de Produtos
    Route::resource('produtos', ProdutoController::class)->middleware(['auth']);

    // Rotas de Tamanhos
    Route::resource('tamanhos', TamanhoController::class)->middleware(['auth']);

    // Rotas de Backups
    Route::resource('backups', BackupController::class);
    Route::get('/backups/{backup}/executar', [BackupController::class, 'executar'])->name('backups.executar');
});

require __DIR__.'/auth.php';
