<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

use App\Http\Controllers\TodosController;


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

// Show Forgot Password Page
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');


// Send Password Reset Link
Route::post('/forgot-password', function (Request $request) {

    $request->validate([
        'email' => ['required', 'email'],
    ]);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    if ($status === Password::ResetLinkSent) {

        return back()->with(
            'success',
            'Password reset link sent to your email.'
        );
    }

    return back()->withErrors([
        'email' => __($status),
    ]);

})->middleware('guest')->name('password.email');


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