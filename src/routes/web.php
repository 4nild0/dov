<?php

use App\Http\Controllers\DeputadoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Página inicial com formulário de busca
Route::get('/', function () {
    return Inertia::render('Buscar');
})->name('buscar.form');

// Endpoint que processa a busca e mostra o resultado
Route::get('/buscar', [DeputadoController::class, 'buscar'])->name('buscar.resultado');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
