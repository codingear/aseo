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

    /**
     * Get all users with their activities
     * Returns only name, email, username and activity names
     */
    public function getAllUsersWithActivities(): JsonResponse
    {
        try {
            $users = User::with(['userActivities.activity'])
                ->where('is_active', true)
                ->get()
                ->map(function ($user) {
                    return [
                        'name' => $user->name,
                        'email' => $user->email,
                        'username' => $user->username,
                        'activities' => $user->userActivities->map(function ($userActivity) {
                            return [
                                'name' => $userActivity->activity->name
                            ];
                        })
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $users,
                'message' => 'All users with activities retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving users with activities: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all users with their activities for today only
     * Returns name, email, username and activity names for today
     */
    public function getAllUsersWithTodayActivities(): JsonResponse
    {
        try {
            // Get current day of week (1=Monday, 7=Sunday)
            $today = now()->dayOfWeek ?: 7;
            
            $users = User::with(['userActivities.activity', 'userActivities.weekday'])
                ->where('is_active', true)
                ->get()
                ->map(function ($user) use ($today) {
                    // Filter activities for today only
                    $todayActivities = $user->userActivities
                        ->filter(function ($userActivity) use ($today) {
                            return $userActivity->weekday->day_number == $today;
                        })
                        ->map(function ($userActivity) {
                            return [
                                'name' => $userActivity->activity->name
                            ];
                        })
                        ->values(); // Reset array keys
                    
                    return [
                        'name' => $user->name,
                        'email' => $user->email,
                        'username' => $user->username,
                        'activities' => $todayActivities
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $users,
                'today' => [
                    'date' => now()->toDateString(),
                    'day_name' => now()->format('l'),
                    'day_number' => $today
                ],
                'message' => 'All users with today activities retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving users with today activities: ' . $e->getMessage()
            ], 500);
        }
    }
}
