<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\StepController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/ideas');

Route::get('/ideas', [IdeaController::class, 'index'])->name('idea.index')->middleware('auth');
Route::post('/ideas', [IdeaController::class, 'store'])->name('idea.store')->middleware('auth');

Route::get('/ideas/{idea}', [IdeaController::class, 'show'])
    ->name('idea.show')
    ->middleware('auth')
    ->can('workWith', 'idea');

Route::delete('/ideas/{idea}', [IdeaController::class, 'destroy'])
    ->name('idea.destroy')
    ->middleware('auth')
    ->can('workWith', 'idea');

Route::get('/ideas/{idea}/edit', [IdeaController::class, 'edit'])
    ->name('idea.edit')
    ->middleware('auth')
    ->can('workWith', 'idea');

Route::patch('/steps/{step}', [StepController::class, 'update'])->name('step.update')->middleware('auth');

Route::get('/register', [RegisterUserController::class, 'create'])->middleware('guest');
Route::post('/register', [RegisterUserController::class, 'store'])->middleware('guest');

Route::get('/login', [LoginController::class, 'create'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'store'])->middleware('guest');

Route::delete('/logout', [LogoutController::class, 'destroy'])->middleware('auth');
