<?php

use App\Http\Controllers\Api\UserActivityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API routes for user activities
Route::prefix('users')->middleware('basicauth')->group(function () {
    // Get all users with their activities
    Route::get('all-with-activities', [UserActivityController::class, 'getAllUsersWithActivities']);
    
    // Get all users with today's activities only
    Route::get('all-with-today-activities', [UserActivityController::class, 'getAllUsersWithTodayActivities']);
    
    // Get user by username
    Route::get('{username}', [UserActivityController::class, 'getUserByUsername']);
    
    // Get user activities for a specific weekday
    Route::get('{username}/activities/weekday/{weekday}', [UserActivityController::class, 'getUserActivitiesByWeekday']);
    
    // Get user activities for today
    Route::get('{username}/activities/today', [UserActivityController::class, 'getUserActivitiesToday']);
    
    // Get all user activities
    Route::get('{username}/activities', [UserActivityController::class, 'getAllUserActivities']);
});
