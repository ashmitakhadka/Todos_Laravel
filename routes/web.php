<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TodosController;
use App\Http\Controllers\PasswordResetController;


// =========================
// Welcome
// =========================

Route::get('/', function () {
    return view('welcome');
});


// =========================
// Authentication Pages
// =========================

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');


// =========================
// Forgot Password
// =========================

// Show forgot password form
Route::get(
    '/forgot-password',
    [PasswordResetController::class, 'showForgotPassword']
)
    ->middleware('guest')
    ->name('password.request');


// Process forgot password form
Route::post(
    '/forgot-password',
    [PasswordResetController::class, 'sendResetLink']
)
    ->middleware('guest')
    ->name('password.email');


// Show new password form
Route::get(
    '/password-reset/{token}',
    [PasswordResetController::class, 'resetPassword']
)
    ->middleware('guest')
    ->name('reset.password');


// Process new password form
Route::post(
    '/password-reset',
    [PasswordResetController::class, 'resetPasswordPost']
)
    ->middleware('guest')
    ->name('reset.password.post');


// =========================
// Todo Routes
// =========================

Route::middleware('auth')->group(function () {

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
});