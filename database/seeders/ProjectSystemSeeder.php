<?php

namespace Database\Seeders;

use App\Models\ProjectSystem;
use Illuminate\Database\Seeder;

class ProjectSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Santa Cruz'],
            ['name' => 'Velasco'],
            ['name' => 'Misiones'],
            ['name' => 'Camiri'],
            ['name' => 'German Bush'],
            ['name' => 'Robore'],
            ['name' => 'Valles'],
        ];

        ProjectSystem::insert($data);
    }
}
