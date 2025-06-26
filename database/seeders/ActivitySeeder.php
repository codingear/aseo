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
            'Hacer comida',
            'Lavar trastes de la comida',
            'Pasear a los niños (tarde)',
            'Hacer desayuno',
            'Lavar trastes del desayuno',
            'Barrer + trapear planta alta',
            'Ordenar sala/comedor',
            'Recoger a Yusef (12 pm)',
            'Hacer cena',
            'Lavar trastes de la cena',
            'Ordenar cocina',
            'Limpiar sillones',
            'Limpiar espejos',
            'Organizar despensa',
            'Ayudar con desayuno',
            'Organizar garaje',
            'Pasear a los niños (mañana)',
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
                    'Llevar a Yusef (9 am)',
                    'Hacer comida',
                    'Lavar trastes de la comida',
                    'Pasear a los niños (tarde)'
                ],
                $susana->id => [
                    'Hacer desayuno',
                    'Lavar trastes del desayuno',
                    'Barrer + trapear planta alta',
                    'Ordenar sala/comedor',
                    'Recoger a Yusef (12 pm)',
                    'Hacer cena',
                    'Lavar trastes de la cena'
                ]
            ],
            // MARTES
            $martes->id => [
                $braulio->id => [
                    'Hacer desayuno',
                    'Lavar trastes del desayuno',
                    'Barrer + trapear planta baja',
                    'Recoger a Yusef (12 pm)',
                    'Hacer cena',
                    'Lavar trastes de la cena'
                ],
                $susana->id => [
                    'Ordenar cocina',
                    'Llevar a Yusef (9 am)',
                    'Limpiar sillones',
                    'Hacer comida',
                    'Lavar trastes de la comida',
                    'Pasear a los niños (tarde)'
                ]
            ],
            // MIÉRCOLES
            $miercoles->id => [
                $braulio->id => [
                    'Sacar basura (8:30 am)',
                    'Barrer + trapear planta baja',
                    'Llevar a Yusef (9 am)',
                    'Hacer comida',
                    'Lavar trastes de la comida',
                    'Pasear a los niños (tarde)'
                ],
                $susana->id => [
                    'Hacer desayuno',
                    'Lavar trastes del desayuno',
                    'Barrer + trapear planta alta',
                    'Recoger a Yusef (12 pm)',
                    'Hacer cena',
                    'Lavar trastes de la cena'
                ]
            ],
            // JUEVES
            $jueves->id => [
                $braulio->id => [
                    'Hacer desayuno',
                    'Lavar trastes del desayuno',
                    'Barrer + trapear planta alta',
                    'Recoger a Yusef (12 pm)',
                    'Hacer cena',
                    'Lavar trastes de la cena'
                ],
                $susana->id => [
                    'Llevar a Yusef (9 am)',
                    'Limpiar espejos',
                    'Organizar despensa',
                    'Hacer comida',
                    'Lavar trastes de la comida',
                    'Pasear a los niños (tarde)'
                ]
            ],
            // VIERNES
            $viernes->id => [
                $braulio->id => [
                    'Sacar basura (8:30 am)',
                    'Barrer + trapear planta baja',
                    'Llevar a Yusef (9 am)',
                    'Hacer comida',
                    'Lavar trastes de la comida'
                ],
                $susana->id => [
                    'Hacer desayuno',
                    'Lavar trastes del desayuno',
                    'Barrer + trapear planta alta',
                    'Recoger a Yusef (12 pm)',
                    'Hacer cena',
                    'Lavar trastes de la cena',
                    'Pasear a los niños (tarde)'
                ]
            ],
            // SÁBADO
            $sabado->id => [
                $braulio->id => [
                    'Ayudar con desayuno',
                    'Lavar trastes del desayuno',
                    'Organizar garaje',
                    'Hacer cena',
                    'Lavar trastes de la cena',
                    'Pasear a los niños (mañana)'
                ],
                $susana->id => [
                    'Limpieza profunda cocina',
                    'Lavar ropa',
                    'Hacer comida',
                    'Lavar trastes de la comida'
                ]
            ],
            // DOMINGO
            $domingo->id => [
                $braulio->id => [
                    'Sacar basura orgánica',
                    'Hacer desayuno',
                    'Lavar trastes del desayuno',
                    'Pasear a los niños (mañana)'
                ],
                $susana->id => [
                    'Preparar comida semanal',
                    'Hacer cena',
                    'Lavar trastes de la cena'
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
