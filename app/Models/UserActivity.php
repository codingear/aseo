<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'activity_id',
        'weekday_id',
        'is_completed',
        'assigned_date'
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'assigned_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function weekday()
    {
        return $this->belongsTo(Weekday::class);
    }
}
