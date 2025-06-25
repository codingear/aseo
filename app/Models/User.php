<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean'
        ];
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'user_activities')
                    ->withPivot('weekday_id', 'is_completed', 'assigned_date')
                    ->withTimestamps();
    }

    public function userActivities()
    {
        return $this->hasMany(UserActivity::class);
    }

    public function getTodayActivities()
    {
        $today = now()->dayOfWeek ?: 7; // Laravel uses 0-6, we use 1-7
        
        return $this->userActivities()
                    ->with(['activity', 'weekday'])
                    ->whereHas('weekday', function($query) use ($today) {
                        $query->where('day_number', $today);
                    })
                    ->where('is_completed', false)
                    ->get();
    }
    
    public function getActivitiesByWeekday($weekdayId)
    {
        return $this->userActivities()
                    ->with(['activity', 'weekday'])
                    ->where('weekday_id', $weekdayId)
                    ->get();
    }

    public function getActivitiesByWeekdayName($weekdayName)
    {
        return $this->userActivities()
                    ->with(['activity', 'weekday'])
                    ->whereHas('weekday', function($query) use ($weekdayName) {
                        $query->where('name', 'like', '%' . $weekdayName . '%');
                    })
                    ->get();
    }
}
