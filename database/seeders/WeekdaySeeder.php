<?php

namespace Database\Seeders;

use App\Models\Weekday;
use Illuminate\Database\Seeder;

class WeekdaySeeder extends Seeder
{
    public function run()
    {
        $weekdays = [
            ['name' => 'Lunes', 'day_number' => 1],
            ['name' => 'Martes', 'day_number' => 2],
            ['name' => 'Miércoles', 'day_number' => 3],
            ['name' => 'Jueves', 'day_number' => 4],
            ['name' => 'Viernes', 'day_number' => 5],
            ['name' => 'Sábado', 'day_number' => 6],
            ['name' => 'Domingo', 'day_number' => 7],
        ];

        foreach ($weekdays as $weekday) {
            Weekday::updateOrCreate(
                ['day_number' => $weekday['day_number']],
                $weekday
            );
        }
    }
}
