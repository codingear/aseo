<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_activities')
                    ->withPivot('weekday_id', 'is_completed', 'assigned_date')
                    ->withTimestamps();
    }

    public function userActivities()
    {
        return $this->hasMany(UserActivity::class);
    }
}
