<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Activity;
use App\Models\Weekday;
use App\Models\UserActivity;
use Illuminate\Http\Request;

class UserActivityController extends Controller
{
    public function index()
    {
        $assignments = UserActivity::with(['user', 'activity', 'weekday'])->paginate(15);
        return view('user-activities.index', compact('assignments'));
    }

    public function create()
    {
        $users = User::where('is_active', true)->get();
        $activities = Activity::where('is_active', true)->get();
        $weekdays = Weekday::orderBy('day_number')->get();
        
        return view('user-activities.create', compact('users', 'activities', 'weekdays'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'activity_id' => 'required|exists:activities,id',
            'weekday_id' => 'required|exists:weekdays,id'
        ]);

        UserActivity::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'activity_id' => $request->activity_id,
                'weekday_id' => $request->weekday_id
            ],
            [
                'is_completed' => false,
                'assigned_date' => now()->toDateString()
            ]
        );

        return redirect()->route('user-activities.index')->with('success', 'Asignación creada exitosamente.');
    }

    public function destroy(UserActivity $userActivity)
    {
        $userActivity->delete();
        return redirect()->route('user-activities.index')->with('success', 'Asignación eliminada exitosamente.');
    }

    public function toggleComplete(UserActivity $userActivity)
    {
        $userActivity->update([
            'is_completed' => !$userActivity->is_completed
        ]);

        return back()->with('success', 'Estado actualizado exitosamente.');
    }
}
