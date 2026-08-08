<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\IdeaImageController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/ideas')->middleware('auth');

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

Route::patch('/ideas/{idea}', [IdeaController::class, 'update'])
    ->name('idea.update')
    ->middleware('auth')
    ->can('workWith', 'idea');

Route::delete('/ideas/{idea}/image', [IdeaImageController::class, 'destroy'])
    ->name('idea.image.destroy')
    ->middleware('auth')
    ->can('workWith', 'idea');

Route::patch('/steps/{step}', [StepController::class, 'update'])->name('step.update')->middleware('auth');

Route::get('/register', [RegisterUserController::class, 'create'])->middleware('guest');
Route::post('/register', [RegisterUserController::class, 'store'])->middleware('guest');

Route::get('/login', [LoginController::class, 'create'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'store'])->middleware('guest');

Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->middleware('guest')
    ->name('google.login');

Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->middleware('guest')
    ->name('google.callback');

Route::delete('/logout', [LogoutController::class, 'destroy'])->middleware('auth');

Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update')->middleware('auth');
