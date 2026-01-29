<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\RelatorioController;

Route::middleware('api')->group(function () {
    Route::apiResource('clientes', ClienteController::class);
    Route::apiResource('cursos', CursoController::class);
    Route::apiResource('categorias', CategoriaController::class);
    Route::apiResource('professores', ProfessorController::class);
    Route::apiResource('vendas', VendaController::class);

    Route::get('relatorios/{tipo}', [RelatorioController::class, 'apiRelatorio']);
    Route::post('relatorios/exportar-pdf', [RelatorioController::class, 'exportarPdf']);
    Route::post('relatorios/exportar-csv', [RelatorioController::class, 'exportarCsv']);
});