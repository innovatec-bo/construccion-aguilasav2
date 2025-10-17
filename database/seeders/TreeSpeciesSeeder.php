<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TreeSpeciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $species = [
            ['name' => 'Desconocida'],
            ['name' => 'Tajibo'],
            ['name' => 'Almendrillo'],
            ['name' => 'Mara'],
            ['name' => 'Cedro'],
            ['name' => 'Paquió'],
            ['name' => 'Bibosi'],
            ['name' => 'Curupay'],
            ['name' => 'Cuchi'],
            ['name' => 'Ochoó'],
            ['name' => 'Serebó'],
            ['name' => 'Mapajo'],
            ['name' => 'Motacú'],
            ['name' => 'Toco'],
            ['name' => 'Sirarí'],
            ['name' => 'Guayabochi'],
            ['name' => 'Bibosi blanco'],

            ['name' => 'Palma real'],
            ['name' => 'Chonta'],
            ['name' => 'Copernicia'],
            ['name' => 'Palma de abanico'],
            ['name' => 'Coco'],

            ['name' => 'Flamboyán'],
            ['name' => 'Jacarandá'],
            ['name' => 'Laurel'],
            ['name' => 'Guayabo'],
            ['name' => 'Mango'],
            ['name' => 'Níspero'],
            ['name' => 'Papaya'],
            ['name' => 'Limón'],
            ['name' => 'Mandarino'],
            ['name' => 'Aguacate'],
            ['name' => 'Plátano'],
            ['name' => 'Guayacán'],
        ];

        DB::table('tree_species')->insert($species);
    }
}
