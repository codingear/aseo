<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\Weekday;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener usuarios
        $braulio = User::where('username', 'braulio')->first();
        $susana = User::where('username', 'susana')->first();

        // Obtener días de la semana
        $lunes = Weekday::where('name', 'Lunes')->first();
        $martes = Weekday::where('name', 'Martes')->first();
        $miercoles = Weekday::where('name', 'Miércoles')->first();
        $jueves = Weekday::where('name', 'Jueves')->first();
        $viernes = Weekday::where('name', 'Viernes')->first();
        $sabado = Weekday::where('name', 'Sábado')->first();
        $domingo = Weekday::where('name', 'Domingo')->first();

        // Definir todas las actividades únicas
        $activities = [
            'Sacar basura (8:30 am)',
            'Barrer + trapear planta baja',
            'Lavar baño planta baja',
            'Llevar a Yusef (9 am)',
            'Hacer desayuno',
            'Barrer + trapear planta alta',
            'Ordenar sala/comedor',
            'Recoger a Yusef (12 pm)',
            'Ordenar cocina',
            'Limpiar sillones',
            'Limpiar espejos',
            'Organizar despensa',
            'Ayudar con desayuno',
            'Organizar garaje',
            'Limpieza profunda cocina',
            'Lavar ropa',
            'Sacar basura orgánica',
            'Preparar comida semanal'
        ];

        // Crear actividades
        foreach ($activities as $activityName) {
            Activity::updateOrCreate(
                ['name' => $activityName],
                [
                    'name' => $activityName,
                    'description' => 'Actividad doméstica',
                    'is_active' => true
                ]
            );
        }

        // Definir asignaciones por día
        $assignments = [
            // LUNES
            $lunes->id => [
                $braulio->id => [
                    'Sacar basura (8:30 am)',
                    'Barrer + trapear planta baja',
                    'Lavar baño planta baja',
                    'Llevar a Yusef (9 am)'
                ],
                $susana->id => [
                    'Hacer desayuno',
                    'Barrer + trapear planta alta',
                    'Ordenar sala/comedor',
                    'Recoger a Yusef (12 pm)'
                ]
            ],
            // MARTES
            $martes->id => [
                $braulio->id => [
                    'Hacer desayuno',
                    'Barrer + trapear planta baja',
                    'Recoger a Yusef (12 pm)'
                ],
                $susana->id => [
                    'Ordenar cocina',
                    'Llevar a Yusef (9 am)',
                    'Limpiar sillones'
                ]
            ],
            // MIÉRCOLES
            $miercoles->id => [
                $braulio->id => [
                    'Sacar basura (8:30 am)',
                    'Barrer + trapear planta baja',
                    'Llevar a Yusef (9 am)'
                ],
                $susana->id => [
                    'Hacer desayuno',
                    'Barrer + trapear planta alta',
                    'Recoger a Yusef (12 pm)'
                ]
            ],
            // JUEVES
            $jueves->id => [
                $braulio->id => [
                    'Hacer desayuno',
                    'Barrer + trapear planta alta',
                    'Recoger a Yusef (12 pm)'
                ],
                $susana->id => [
                    'Llevar a Yusef (9 am)',
                    'Limpiar espejos',
                    'Organizar despensa'
                ]
            ],
            // VIERNES
            $viernes->id => [
                $braulio->id => [
                    'Sacar basura (8:30 am)',
                    'Barrer + trapear planta baja',
                    'Llevar a Yusef (9 am)'
                ],
                $susana->id => [
                    'Hacer desayuno',
                    'Barrer + trapear planta alta',
                    'Recoger a Yusef (12 pm)'
                ]
            ],
            // SÁBADO
            $sabado->id => [
                $braulio->id => [
                    'Ayudar con desayuno',
                    'Organizar garaje'
                ],
                $susana->id => [
                    'Limpieza profunda cocina',
                    'Lavar ropa'
                ]
            ],
            // DOMINGO
            $domingo->id => [
                $braulio->id => [
                    'Sacar basura orgánica'
                ],
                $susana->id => [
                    'Preparar comida semanal'
                ]
            ]
        ];

        // Crear las asignaciones de actividades a usuarios
        foreach ($assignments as $weekdayId => $userActivities) {
            foreach ($userActivities as $userId => $activities) {
                foreach ($activities as $activityName) {
                    $activity = Activity::where('name', $activityName)->first();
                    
                    if ($activity) {
                        UserActivity::updateOrCreate(
                            [
                                'user_id' => $userId,
                                'activity_id' => $activity->id,
                                'weekday_id' => $weekdayId,
                            ],
                            [
                                'is_completed' => false,
                                'assigned_date' => now()->toDateString()
                            ]
                        );
                    }
                }
            }
        }
    }
}
