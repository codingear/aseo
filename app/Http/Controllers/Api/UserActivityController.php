<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Weekday;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserActivityController extends Controller
{
    /**
     * Get user information by username
     */
    public function getUserByUsername($username): JsonResponse
    {
        try {
            $user = User::where('username', $username)->first();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }
            
            $user->load(['userActivities.activity', 'userActivities.weekday']);
            
            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'User retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving user: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user activities for a specific weekday by username
     */
    public function getUserActivitiesByWeekday($username, $weekday): JsonResponse
    {
        try {
            $user = User::where('username', $username)->first();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }
            // If weekday is a number, find by day_number, otherwise by name
            if (is_numeric($weekday)) {
                $weekdayModel = Weekday::where('day_number', $weekday)->first();
            } else {
                $weekdayModel = Weekday::where('name', 'like', '%' . $weekday . '%')->first();
            }

            if (!$weekdayModel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Weekday not found'
                ], 404);
            }

            $activities = $user->userActivities()
                ->with(['activity', 'weekday'])
                ->where('weekday_id', $weekdayModel->id)
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $user->only(['id', 'name', 'email']),
                    'weekday' => $weekdayModel,
                    'activities' => $activities
                ],
                'message' => 'User activities retrieved successfully for ' . $weekdayModel->name
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving activities: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user activities for today by username
     */
    public function getUserActivitiesToday($username): JsonResponse
    {
        try {
            $user = User::where('username', $username)->first();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }
            
            // Get current day of week (1=Monday, 7=Sunday)
            $today = now()->dayOfWeek ?: 7;
            
            $todayWeekday = Weekday::where('day_number', $today)->first();
            
            if (!$todayWeekday) {
                return response()->json([
                    'success' => false,
                    'message' => 'Today weekday configuration not found'
                ], 404);
            }

            $activities = $user->userActivities()
                ->with(['activity', 'weekday'])
                ->where('weekday_id', $todayWeekday->id)
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $user->only(['id', 'name', 'email']),
                    'today' => [
                        'date' => now()->toDateString(),
                        'day_name' => now()->format('l'),
                        'weekday' => $todayWeekday
                    ],
                    'activities' => $activities
                ],
                'message' => 'Today activities retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving today activities: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all user activities grouped by weekday by username
     */
    public function getAllUserActivities($username): JsonResponse
    {
        try {
            $user = User::where('username', $username)->first();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }
            
            $activities = $user->userActivities()
                ->with(['activity', 'weekday'])
                ->get()
                ->groupBy('weekday.name');

            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $user->only(['id', 'name', 'email']),
                    'activities_by_weekday' => $activities
                ],
                'message' => 'All user activities retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving all activities: ' . $e->getMessage()
            ], 500);
        }
    }
}
