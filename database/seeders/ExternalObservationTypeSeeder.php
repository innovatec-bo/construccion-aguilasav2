<?php

namespace Database\Seeders;

use App\Models\ExternalObservationType;
use Illuminate\Database\Seeder;

class ExternalObservationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Poste Inclinado',
                'slug' => 'poste-inclinado'
            ],
            [
                'name' => 'Poste Fuera de Norma',
                'slug' => 'poste-fuera-de-norma'
            ],
            [
                'name' => 'Estructura Mal Instalada',
                'slug' => 'estructura-mal-instalada'
            ],
            [
                'name' => 'Rienda Mal Instalada',
                'slug' => 'rienda-mal-instalada'
            ],
            [
                'name' => 'Ancla Mal Instalada',
                'slug' => 'ancla-mal-instalada'
            ],
            [
                'name' => 'Falta Trabajo de Línea Viva',
                'slug' => 'falta-trabajo-de-línea-viva'
            ],
            [
                'name' => 'Realizar Poda',
                'slug' => 'realizar-poda'
            ],
            [
                'name' => 'Limpieza del Área de Trabajo',
                'slug' => 'limpieza-del-area-de-trabajo'
            ],
            [
                'name' => 'Varios',
                'slug' => 'varios'
            ]
        ];

        ExternalObservationType::insert($data);
    }
}
