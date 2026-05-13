<?php

use App\Http\Controllers\AiEngineController;
use App\Http\Controllers\ProcessingProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Guest Routes

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'create']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/users/authenticate', [UserController::class, 'authenticate']);
});

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/ai-settings', [AiEngineController::class, 'index']);
    Route::post('/ai-settings', [AiEngineController::class, 'store'])->name('ai-settings.store');

    Route::resource('processing-profiles', ProcessingProfileController::class)->except(['show']);

    Route::resource('products', ProductController::class);
    Route::get('/editUser', [UserController::class, 'editPage']);
    Route::post('/storeEditUser', [UserController::class, 'storeEditUser']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});
