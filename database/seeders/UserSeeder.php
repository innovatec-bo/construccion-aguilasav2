<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Jair',
            'last_name' => 'Cussy',
            'email' => 'jair@twiiti.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Super admin');
    }
}
