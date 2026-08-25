<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodosController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/todos', [TodosController::class, 'index'])
    ->name('todos.index');

Route::get('/todos/create', [TodosController::class, 'create'])
    ->name('todos.create');

Route::post('/todos', [TodosController::class, 'store'])
    ->name('todos.store');

Route::get('/todos/{todo}/edit', [TodosController::class, 'edit'])
    ->name('todos.edit');

Route::put('/todos/{todo}', [TodosController::class, 'update'])
    ->name('todos.update');

Route::delete('/todos/{todo}', [TodosController::class, 'destroy'])
    ->name('todos.destroy');
Route::patch('/todos/{todo}/complete', [TodosController::class, 'complete'])
    ->name('todos.complete');