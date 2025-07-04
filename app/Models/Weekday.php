<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weekday extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'day_number'
    ];

    public function userActivities()
    {
        return $this->hasMany(UserActivity::class);
    }
}
