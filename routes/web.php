<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\UserActivityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Users routes
    Route::resource('users', UserController::class);
    
    // Activities routes
    Route::resource('activities', ActivityController::class);
    
    // User Activities routes
    Route::resource('user-activities', UserActivityController::class);
    Route::patch('user-activities/{userActivity}/toggle', [UserActivityController::class, 'toggleComplete'])
        ->name('user-activities.toggle');
});

Auth::routes();

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
